<?php

namespace Zheltikov\Xhp\Core;

// <<__Sealed(primitive::class, element::class)>>
use ReflectionClass;
use Zheltikov\Xhp\Exceptions\AttributeNotSupportedException;
use Zheltikov\Xhp\Exceptions\AttributeRequiredException;
use Zheltikov\Xhp\Exceptions\InvalidChildrenException;
use Zheltikov\Xhp\Exceptions\RenderArrayException;
use Zheltikov\Xhp\Lib\C;
use Zheltikov\Xhp\Lib\Dict;
use Zheltikov\Xhp\Lib\Str;
use Zheltikov\Xhp\Lib\Vec;
use Zheltikov\Xhp\Reflection\ReflectionXHPAttribute;
use Zheltikov\Xhp\Reflection\ReflectionXHPChildrenDeclaration;
use Zheltikov\Xhp\Reflection\ReflectionXHPChildrenExpression;
use Zheltikov\Xhp\Reflection\XHPChildrenConstraintType;
use Zheltikov\Xhp\Reflection\XHPChildrenDeclarationType;
use Zheltikov\Xhp\Reflection\XHPChildrenExpressionType;
use Zheltikov\Memoize;

use function Zheltikov\Invariant\{invariant, invariant_violation};

abstract class Node implements XHPChild
{
    use Memoize\Helper;

    // Must be kept in sync with compiler
    const SPREAD_PREFIX = '...$';

    /**
     * @var bool
     */
    protected $__isRendered = false;

    /**
     * @var array
     * dict<string, mixed>
     */
    private $attributes = [];

    /**
     * @var array
     * vec<\XHPChild>
     */
    private $children = [];

    /**
     * @var array
     * dict<string, mixed>
     */
    private $context = [];

    /**
     * @var string|null
     */
    public $source = null;

    protected function init(): void
    {
    }

    /**
     * A new :x:node is instantiated for every literal tag
     * expression in the script.
     *
     * The following code:
     * $foo = <foo attr="val">bar</foo>;
     *
     * will execute something like:
     * $foo = new xhp_foo(array('attr' => 'val'), array('bar'));
     *
     * @param array $attributes (KeyedTraversable<string, mixed>) map of attributes to values
     * @param array $children (Traversable<?\XHPChild>) list of children
     * @param mixed $debug_info (dynamic) will in the source when childValidation is enabled
     * @throws \Zheltikov\Exceptions\InvariantException
     */
    final public function __construct(array $attributes = [], array $children = [], ...$debug_info)
    {
        invariant(
            $this->__xhpChildrenDeclaration() === self::__NO_LEGACY_CHILDREN_DECLARATION,
            'The `children` keyword is no longer supported',
        );

        invariant(
            $this->__xhpCategoryDeclaration() === self::__NO_LEGACY_CATEGORY_DECLARATION,
            'The `category` keyword is no longer supported',
        );

        foreach ($children as $child) {
            $this->appendChild($child);
        }

        foreach ($attributes as $key => $value) {
            if (self::isSpreadKey($key)) {
                invariant(
                    $value instanceof Node,
                    'Only XHP can be used with an attribute spread operator',
                );
                $this->spreadElementImpl($value);
            } else {
                $this->setAttribute($key, $value);
            }
        }

        if (ChildValidation::is_enabled()) {
            if (C::count($debug_info) >= 2) {
                // TODO: filename:line
                $this->source = $debug_info[0] . ':' . $debug_info[1];
            } else {
                $this->source =
                    'You have child validation on, but debug information is not being ' .
                    'passed to XHP objects correctly. Ensure xhp.include_debug is on ' .
                    'in your server configuration. Without this option enabled, ' .
                    'validation errors will be painful to debug at best.';
            }
        }
        $this->init();
    }

    abstract public function toString(): string;

    /**
     * Adds a child to the end of this node. If you give a Traversable to this method
     * then it will behave like a DocumentFragment.
     *
     * @param mixed $child single child or a Traversable of children
     * @return $this
     * @throws UseAfterRenderException
     */
    final public function appendChild($child): self
    {
        if ($this->__isRendered) {
            throw new UseAfterRenderException(Str::format("Can't %s after render", __FUNCTION__));
        }
        if (is_iterable($child)) {
            foreach ($child as $c) {
                $this->appendChild($c);
            }
        } else {
            if ($child instanceof Frag) {
                foreach ($child->getChildren() as $new_child) {
                    $this->children[] = $new_child;
                }
            } else {
                if ($child !== null) {
                    $this->children[] = $child; // as \XHPChild;
                }
            }
        }
        return $this;
    }

    /**
     * Replaces all children in this node.
     *
     * @param XHPChild[] $children single child or a Traversable of children
     * @return $this
     * @throws UseAfterRenderException
     */
    final public function replaceChildren(array $children): self
    {
        if ($this->__isRendered) {
            throw new UseAfterRenderException(Str::format("Can't %s after render", __FUNCTION__));
        }
        // This function has been micro-optimized
        $new_children = [];
        foreach ($children as $xhp) {
            if ($xhp instanceof Frag) {
                foreach ($xhp->children as $child) {
                    $new_children[] = $child;
                }
            } else {
                if (!is_iterable($xhp)) {
                    $new_children[] = $xhp;
                } else {
                    foreach ($xhp as $element) {
                        if ($element instanceof Frag) {
                            foreach ($element->children as $child) {
                                $new_children[] = $child;
                            }
                        } else {
                            if ($element !== null) {
                                $new_children[] = $element; // as \XHPChild;
                            }
                        }
                    }
                }
            }
        }
        $this->children = $new_children;
        return $this;
    }

    /**
     * Fetches all direct children of this element.
     * vec<\XHPChild>
     */
    final public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * Fetches all direct children of this element of the given type.
     */
    public function getFilteredChildren(callable $callback): array
    {
        $children = [];
        foreach ($this->children as $child) {
            if (call_user_func($callback, $child)) {
                $children[] = $child;
            }
        }
        return $children;
    }

    /**
     * Fetches the first direct child of the element, if any.
     */
    final public function getFirstChild(): ?XHPChild
    {
        return $this->children[0] ?? null;
    }

    /**
     * Fetch the first direct child of the element.
     *
     * An exception is thrown if the element has no children.
     * @throws \Zheltikov\Exceptions\InvariantException
     */
    public function getFirstChildx(): XHPChild
    {
        $child = $this->getFirstChild();

        if ($child !== null) {
            return $child;
        }

        invariant_violation('%s called on element with no children', __FUNCTION__);
    }

    /**
     * Fetch the first direct child of a given type, if any.
     *
     * If no matching child is present, returns `null`.
     */
    public function getFirstFilteredChild(callable $callback): ?XHPChild
    {
        foreach ($this->children as $child) {
            if (call_user_func($callback, $child)) {
                return $child;
            }
        }
        return null;
    }

    /**
     * Fetch the first direct child of a given type.
     *
     * If no matching child is present, an exception is thrown.
     * @throws \Zheltikov\Exceptions\InvariantException
     */
    public function getFirstFilteredChildx(callable $callback): XHPChild
    {
        $child = $this->getFirstFilteredChild($callback);

        invariant(
            $child !== null,
            '%s called with no matching child',
            __FUNCTION__,
        );

        return $child;
    }

    /**
     * Fetches the last direct child of the element, if any.
     *
     * If the element has no children, `null` is returned.
     */
    final public function getLastChild(): ?XHPChild
    {
        return C::last($this->getChildren());
    }

    /**
     * Fetches the last direct child of the element.
     *
     * If the element has no children, an exception is thrown.
     * @throws \Zheltikov\Exceptions\InvariantException
     */
    public function getLastChildx(): XHPChild
    {
        $child = $this->getLastChild();

        if ($child !== null) {
            return $child;
        }

        invariant_violation('%s called on element with no children', __FUNCTION__);
    }

    /**
     * Fetch the last direct child of the element of a given type, if any.
     *
     * If the element has no matching children, `null` is returned.
     */
    public function getLastFilteredChild(callable $callback): ?XHPChild
    {
        for ($i = C::count($this->children) - 1; $i >= 0; --$i) {
            $child = $this->children[$i];
            if (call_user_func($callback, $child)) {
                return $child;
            }
        }
        return null;
    }

    /**
     * Fetch the last direct child of the element of a given type.
     *
     * If the element has no matching children, an exception is thrown.
     * @throws \Zheltikov\Exceptions\InvariantException
     */
    public function getLastFilteredChildx(callable $callback): XHPChild
    {
        $child = $this->getLastFilteredChild($callback);

        invariant($child !== null, '%s called with no matching child', __FUNCTION__);

        return $child;
    }

    /**
     * Fetches an attribute from this elements attribute store. If $attr is not
     * defined in the store and is not a data- or aria- attribute an exception
     * will be thrown. An exception will also be thrown if $attr is required and
     * not set.
     *
     * @param string $attr attribute to fetch
     * @return mixed           value
     * @throws \Zheltikov\Xhp\Exceptions\AttributeNotSupportedException
     * @throws \Zheltikov\Xhp\Exceptions\AttributeRequiredException
     */
    final public function getAttribute(string $attr) // : mixed
    {
        // Return the attribute if it's there
        if (C::contains_key($this->attributes, $attr)) {
            return $this->attributes[$attr];
        }

        if (!ReflectionXHPAttribute::isSpecial($attr)) {
            // Get the declaration
            $decl = static::__xhpReflectionAttribute($attr);

            if ($decl === null) {
                throw new AttributeNotSupportedException($this, $attr);
            } else {
                if ($decl->isRequired()) {
                    throw new AttributeRequiredException($this, $attr);
                } else {
                    return $decl->getDefaultValue();
                }
            }
        } else {
            return null;
        }
    }

    final public static function __xhpReflectionAttribute(string $attr): ?ReflectionXHPAttribute
    {
        return static::__xhpReflectionAttributes()[$attr] ?? null;
    }

    // TODO: test lsb memoization
    final public static function __xhpReflectionAttributes(): array // dict<string, ReflectionXHPAttribute>
    {
        return static::memoizeLSB(
            function (): array {
                $decl = static::__xhpAttributeDeclaration();
                return Dict::map_with_key(
                    $decl,
                    function ($name, $attr_decl) {
                        return new ReflectionXHPAttribute($name, $attr_decl);
                    }
                );
            }
        );
    }

    /**
     * @return mixed
     * @throws \Zheltikov\Exceptions\InvariantException
     */
    protected static function __legacySerializedXHPChildrenDeclaration() // : mixed
    {
        invariant(
            self::emptyInstance()->__xhpChildrenDeclaration() ===
            self::__NO_LEGACY_CHILDREN_DECLARATION,
            'Legacy XHP children declaration syntax is no longer supported',
        );

        return 1; // any children
    }

    // TODO: test lsb memoization
    final public static function __xhpReflectionChildrenDeclaration(): ReflectionXHPChildrenDeclaration
    {
        return static::memoizeLSB(
            function (): ReflectionXHPChildrenDeclaration {
                return new ReflectionXHPChildrenDeclaration(
                    static::class,
                    static::__legacySerializedXHPChildrenDeclaration(),
                );
            }
        );
    }

    final public static function __xhpReflectionCategoryDeclaration(): array // keyset<string>
    {
        return Vec::keys(self::emptyInstance()->__xhpCategoryDeclaration());
    }

    // Work-around to call methods that should be static without a real
    // instance.
    // TODO: test lsb memoization
    /**
     * @return $this
     */
    private static function emptyInstance(): self
    {
        return static::memoizeLSB(
            function (): Node {
                return (new ReflectionClass(static::class))
                    ->newInstanceWithoutConstructor();
            }
        );
    }

    final public function getAttributes(): array // dict<string, mixed>
    {
        return $this->attributes;
    }


    /**
     * Determines if a given XHP attribute "key" represents an XHP spread operator
     * in the constructor.
     */
    private static function isSpreadKey(string $key): bool
    {
        return Str::starts_with($key, self::SPREAD_PREFIX);
    }

    /**
     * Implements the XHP spread operator in expressions like:
     *   <foo attr1="bar" {...$xhp} />
     *
     * This will only copy defined attributes on $xhp to when they are also
     * defined on $this, or if they are "special" data-/aria- attributes.
     *
     * Defaults from $xhp are copied as well, if they are present.
     */
    protected final function spreadElementImpl(Node $element): void
    {
        $attrs = Dict::merge(
            Dict::map(
                Dict::filter(
                    $element::__xhpReflectionAttributes(),
                    function ($attr) {
                        return $attr->hasDefaultValue();
                    }
                ),
                function ($attr) {
                    return $attr->getDefaultValue();
                }
            ),
            $element->getAttributes()
        );

        foreach ($attrs as $attr_name => $value) {
            if ($value === null) {
                continue;
            }

            if (
                !ReflectionXHPAttribute::isSpecial($attr_name)
                && static::__xhpReflectionAttribute($attr_name) === null
            ) {
                continue;
            }

            // If the receiving class has the same attribute and we had a value or
            // a default, then copy it over.
            $this->setAttribute($attr_name, $value);
        }
    }

    /**
     * Sets an attribute in this element's attribute store.
     *
     * @param string $attr attribute to set
     * @param mixed $value value
     * @return $this
     * @throws UseAfterRenderException
     */
    final public function setAttribute(string $attr, $value): self
    {
        if ($this->__isRendered) {
            throw new UseAfterRenderException(Str::format("Can't %s after render", __FUNCTION__));
        }
        $this->attributes[$attr] = $value;
        return $this;
    }

    /**
     * Takes a KeyedContainer and adds each as an attribute.
     *
     * @param array $attrs KeyedContainer of attributes
     * @return $this
     */
    final public function setAttributes(array $attrs): self
    {
        foreach ($attrs as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * Whether the attribute has been explicitly set in either the XhpOpenTag
     * or using setAttribute(). An attribute with a default value is not
     * automatically considered set. Explicitly setting a value, which may be
     * the same as the default value, will cause this method to return true.
     *
     * @param string $attr attribute to check
     */
    final public function isAttributeSet(string $attr): bool
    {
        return C::contains_key($this->attributes, $attr);
    }

    /**
     * Removes an attribute from this element's attribute store.
     *
     * @param string $attr attribute to remove
     * @return $this
     * @throws UseAfterRenderException
     */
    final public function removeAttribute(string $attr): self
    {
        if ($this->__isRendered) {
            throw new UseAfterRenderException(Str::format("Can't %s after render", __FUNCTION__));
        }
        unset($this->attributes[$attr]);
        return $this;
    }

    /**
     * @param string $attr attribute to set
     * @param mixed $value value
     * @return $this
     * @throws UseAfterRenderException
     * @deprecated This functionality will be removed in a future release.
     *
     * This has not yet been removed as it is currently the only way to
     * set an `UnsafeAttributeValue_DEPRECATED`.
     *
     * Sets an attribute in this element's attribute store. Always foregoes
     * validation.
     *
     */
    final public function forceAttribute_DEPRECATED(string $attr, $value): self
    {
        if ($this->__isRendered) {
            throw new UseAfterRenderException(Str::format("Can't %s after render", __FUNCTION__));
        }
        $this->attributes[$attr] = $value;
        return $this;
    }

    /**
     * Returns all contexts currently set.
     *
     * @return  array         All contexts
     * dict<string, mixed >
     */
    final public function getAllContexts(): array
    {
        return $this->context;
    }

    /**
     * Returns a specific context value. Can include a default if not set.
     *
     * @param string $key The context key
     * @param mixed $default The value to return if not set (optional)
     * @return mixed          The context value or $default
     */
    final public function getContext(string $key, $default = null) // : mixed
    {
        // You can't use ?? here, since the context may contain nulls.
        if (C::contains_key($this->context, $key)) {
            return $this->context[$key];
        }
        return $default;
    }

    /**
     * Sets a value that will be automatically passed down through a render chain
     * and can be referenced by children and composed elements. For instance, if
     * a root element sets a context of "admin_mode" = true, then all elements
     * that are rendered as children of that root element will receive this
     * context WHEN RENDERED. The context will not be available before render.
     *
     * @param string $key The key
     * @param mixed $value The value to set
     * @return           $this
     * @throws UseAfterRenderException
     */
    final public function setContext(string $key, $value): self
    {
        if ($this->__isRendered) {
            throw new UseAfterRenderException(Str::format("Can't %s after render", __FUNCTION__));
        }
        $this->context[$key] = $value;
        return $this;
    }

    /**
     * Sets a value that will be automatically passed down through a render chain
     * and can be referenced by children and composed elements. For instance, if
     * a root element sets a context of "admin_mode" = true, then all elements
     * that are rendered as children of that root element will receive this
     * context WHEN RENDERED. The context will not be available before render.
     *
     * @param array $context A map of key/value pairs
     * @return               $this
     * @throws UseAfterRenderException
     */
    final public function addContextMap(array $context): self
    {
        if ($this->__isRendered) {
            throw new UseAfterRenderException(Str::format("Can't %s after render", __FUNCTION__));
        }

        $this->context = Dict::merge($this->context, $context);
        return $this;
    }

    /**
     * Transfers the context but will not overwrite anything. This is done only
     * for rendering because we don't want a parent's context to replace a
     * child's context if they have the same key.
     *
     * @param array $parentContext The context to transfer
     */
    final protected function __transferContext(array $parentContext): void
    {
        foreach ($parentContext as $key => $value) {
            // You can't use ??= here, since context may contain nulls.
            if (!C::contains_key($this->context, $key)) {
                $this->context[$key] = $value;
            }
        }
    }

    abstract protected function __flushSubtree(): Primitive;

    /**
     * Defined in elements by the `attribute` keyword. The declaration is simple.
     * There is a keyed array, with each key being an attribute. Each value is
     * an array with 4 elements. The first is the attribute type. The second is
     * meta-data about the attribute. The third is a default value (null for
     * none). And the fourth is whether or not this value is required.
     *
     * Attribute types are suggested by the TYPE_* constants.
     * darray<string, varray < mixed >>
     */
    protected static function __xhpAttributeDeclaration(): array
    {
        return [];
    }

    /**
     * Defined in elements by the `category` keyword. This is just a list of all
     * categories an element belongs to. Each category is a key with value 1.
     * darray<string, int >
     */
    protected function __xhpCategoryDeclaration(): array
    {
        return self::__NO_LEGACY_CATEGORY_DECLARATION;
    }

    const __NO_LEGACY_CHILDREN_DECLARATION = -31337;
    /**
     * darray<string, int>
     */
    const __NO_LEGACY_CATEGORY_DECLARATION = ["\0INVALID\0" => 0];

    /**
     * Defined in elements by the `children` keyword. This returns a pattern of
     * allowed children. The return value is potentially very complicated. The
     * two simplest are 0 and 1 which mean no children and any children,
     * respectively. Otherwise you're dealing with an array which is just the
     * biggest mess you've ever seen.
     * @return mixed
     */
    protected function __xhpChildrenDeclaration() // : mixed
    {
        return self::__NO_LEGACY_CHILDREN_DECLARATION;
    }

    /**
     * Validates that this element's children match its children descriptor, and
     * throws an exception if that's not the case.
     * @throws \Zheltikov\Xhp\Exceptions\InvalidChildrenException
     */
    protected function validateChildren(): void
    {
        $decl = self::__xhpReflectionChildrenDeclaration();
        $type = $decl->getType();
        if ($type === XHPChildrenDeclarationType::ANY_CHILDREN()) {
            return;
        }
        if ($type === XHPChildrenDeclarationType::NO_CHILDREN()) {
            if ($this->children) {
                throw new InvalidChildrenException($this, 0);
            } else {
                return;
            }
        }
        [$ret, $ii] = $this->validateChildrenExpression(
            $decl->getExpression(),
            0,
        );
        if (!$ret || $ii < C::count($this->children)) {
            if (($this->children[$ii] ?? null) instanceof AlwaysValidChild) {
                return;
            }
            throw new InvalidChildrenException($this, $ii);
        }
    }

    /**
     * @param \Zheltikov\Xhp\Reflection\ReflectionXHPChildrenExpression $expr
     * @param int $index
     * @return array
     * (bool, int)
     * final
     */
    private function validateChildrenExpression(
        ReflectionXHPChildrenExpression $expr,
        int $index
    ): array {
        switch ($expr->getType()) {
            case XHPChildrenExpressionType::SINGLE():
                // Exactly once -- :fb_thing
                return $this->validateChildrenRule($expr, $index);
            case XHPChildrenExpressionType::ANY_NUMBER():
                // Zero or more times -- :fb_thing*
                do {
                    [$ret, $index] = $this->validateChildrenRule($expr, $index);
                } while ($ret);
                return [true, $index];

            case XHPChildrenExpressionType::ZERO_OR_ONE():
                // Zero or one times -- :fb_thing?
                [$_, $index] = $this->validateChildrenRule($expr, $index);
                return [true, $index];

            case XHPChildrenExpressionType::ONE_OR_MORE():
                // One or more times -- :fb_thing+
                [$ret, $index] = $this->validateChildrenRule($expr, $index);
                if (!$ret) {
                    return [false, $index];
                }
                do {
                    [$ret, $index] = $this->validateChildrenRule($expr, $index);
                } while ($ret);
                return [true, $index];

            case XHPChildrenExpressionType::SUB_EXPR_SEQUENCE():
                // Specific order -- :fb_thing, :fb_other_thing
                $oindex = $index;
                [$sub_expr_1, $sub_expr_2] = $expr->getSubExpressions();
                [$ret, $index] = $this->validateChildrenExpression(
                    $sub_expr_1,
                    $index,
                );
                if ($ret) {
                    [$ret, $index] = $this->validateChildrenExpression(
                        $sub_expr_2,
                        $index,
                    );
                }
                if ($ret) {
                    return [true, $index];
                }
                return [false, $oindex];

            case XHPChildrenExpressionType::SUB_EXPR_DISJUNCTION():
                // Either or -- :fb_thing | :fb_other_thing
                $oindex = $index;
                [$sub_expr_1, $sub_expr_2] = $expr->getSubExpressions();
                [$ret, $index] = $this->validateChildrenExpression(
                    $sub_expr_1,
                    $index,
                );
                if (!$ret) {
                    [$ret, $index] = $this->validateChildrenExpression(
                        $sub_expr_2,
                        $index,
                    );
                }
                if ($ret) {
                    return [true, $index];
                }
                return [false, $oindex];
        }
    }

    /**
     * @param \Zheltikov\Xhp\Reflection\ReflectionXHPChildrenExpression $expr
     * @param int $index
     * @return array
     * (bool, int)
     * final
     */
    private function validateChildrenRule(
        ReflectionXHPChildrenExpression $expr,
        int $index
    ): array {
        switch ($expr->getConstraintType()) {
            case XHPChildrenConstraintType::ANY():
                if (C::contains_key($this->children, $index)) {
                    return [true, $index + 1];
                }

                return [false, $index];

            case XHPChildrenConstraintType::PCDATA():
                if (
                    C::contains_key($this->children, $index)
                    && !($this->children[$index] instanceof Node)
                ) {
                    return [true, $index + 1];
                }
                return [false, $index];

            case XHPChildrenConstraintType::ELEMENT():
                $class = $expr->getConstraintString();
                if (
                    C::contains_key($this->children, $index)
                    && is_a($this->children[$index], $class, true)
                ) {
                    return [true, $index + 1];
                }
                return [false, $index];

            case XHPChildrenConstraintType::CATEGORY():
                if (!C::contains_key($this->children, $index)) {
                    return [false, $index];
                }
                $child = $this->children[$index];
                if (!$child instanceof Node) {
                    return [false, $index];
                }
                $category = Str::replace(
                    Str::replace(
                        $expr->getConstraintString(),
                        '__',
                        ':'
                    ),
                    '_',
                    '-'
                );

                $categories = $child->__xhpCategoryDeclaration();
                if (($categories[$category] ?? 0) === 0) {
                    return [false, $index];
                }
                return [true, $index + 1];

            case XHPChildrenConstraintType::SUB_EXPR():
                return $this->validateChildrenExpression(
                    $expr->getSubExpression(),
                    $index,
                );
        }
    }

    /**
     * Returns the human-readable `children` declaration as seen in this class's
     * source code.
     *
     * Keeping this wrapper around reflection, as it fits well with
     * __getChildrenDescription.
     */
    public function __getChildrenDeclaration(): string
    {
        return self::__xhpReflectionChildrenDeclaration()->__toString();
    }

    /**
     * Returns a description of the current children in this element. Maybe
     * something like this:
     * <div><span>foo</span>bar</div> ->
     * :span[%inline],pcdata
     */
    final public function __getChildrenDescription(): string
    {
        $desc = [];
        foreach ($this->children as $child) {
            if ($child instanceof Node) {
                $tmp = '\\' . get_class($child);
                // FIXME: call to __xhpCategoryDeclaration always results in ["\0INVALID\0" => 0]
                $categories = $child->__xhpCategoryDeclaration();
                if (C::count($categories) > 0) {
                    $tmp .= '[%' . Str::join(Vec::keys($categories), ',%') . ']';
                }
                $desc[] = $tmp;
            } else {
                $desc[] = 'pcdata';
            }
        }
        return Str::join($desc, ',');
    }

    final public function categoryOf(string $c): bool
    {
        $categories = $this->__xhpCategoryDeclaration();
        if (($categories[$c] ?? null) !== null) {
            return true;
        }
        // XHP parses the category string
        $c = str_replace([':', '-'], ['__', '_'], $c);
        return ($categories[$c] ?? null) !== null;
    }

    /**
     * @param \Zheltikov\Xhp\Core\XHPChild|\Stringable|string $child
     * @return string
     * @throws \Zheltikov\Xhp\Exceptions\RenderArrayException
     */
    final protected static function renderChild($child): string
    {
        if ($child instanceof Node) {
            return $child->toString();
        }

        if ($child instanceof UnsafeRenderable) {
            return $child->toHTMLString();
        }
        if (is_iterable($child)) {
            throw new RenderArrayException('Can not render traversables!');
        }

        /* HH_FIXME[4281] stringish migration */
        return htmlspecialchars((string) $child);
    }
}

%pure_parser
%expect 2

%tokens

%%

root : node_list                        { $$ = $1; }
     ;

node_list : node_list node              { $$ = ($1)->appendChild($2); }
          | node                        { $$ = new NodeList($1); }
          | /* empty */                 { $$ = new NodeList(null); }
          ;

node : text                             { $$ = $1; }
     | entity                           { $$ = $1; }
     | tag                              { $$ = $1; }
     ;

text : TOKEN_TEXT                       { $$ = $1; }
     ;

entity : TOKEN_ENTITY                   { $$ = $1; }
       ;

tag : self_closing_tag                  { $$ = $1; }
    | tag_with_children                 { $$ = $1; }
    ;

self_closing_tag : TOKEN_OPEN_TAG optional_whitespace tag_name whitespace
                   attribute_list optional_whitespace TOKEN_SELF_CLOSE
                                        { $$ = (new Node($3))
                                          ->setAttributes($5); }
                 ;

tag_with_children : TOKEN_OPEN_TAG optional_whitespace tag_name whitespace
                    attribute_list optional_whitespace TOKEN_CLOSE_TAG node_list
                    TOKEN_OPEN_TAG_CLOSING optional_whitespace tag_name
                    optional_whitespace TOKEN_CLOSE_TAG
                                        { assert($3 === $11, 'Opening and closing tag names match');
                                          $$ = (new Node($3))
                                          ->setAttributes($5)->setChildren($8); }
                  ;

attribute_list : attribute_list optional_whitespace attribute
                                        { $$ = ($1)->appendChild($3); }
               | attribute              { $$ = new AttributeList($1); }
               | /* empty */            { $$ = new AttributeList(null); }
               ;

attribute : attribute_name TOKEN_EQUALS attribute_value
                                        { $$ = new Attribute($1, $2); }
          | attribute_name              { $$ = new Attribute($1); }
          ;

attribute_value : string_attribute_value
                | php_expression_attr
                ;

string_attribute_value : TOKEN_DQUOTE string_attribute_value_data TOKEN_DQUOTE
                                        { $$ = $2; }
                       ;

php_expression_attr : TOKEN_CURLY_OPEN php_expression TOKEN_CURLY_CLOSE
                                        { $$ = $2; }
                    ;

php_expression : raw_integer
               | raw_float
               | raw_boolean
               | raw_null
               | raw_string
               ;

raw_integer : TOKEN_RAW_INTEGER         { $$ = intval($1); }
            ;

raw_float : TOKEN_RAW_FLOAT             { $$ = floatval($1); }
          ;

raw_boolean : TOKEN_RAW_TRUE            { $$ = true; }
            | TOKEN_RAW_FALSE           { $$ = false; }
            ;

raw_null : TOKEN_RAW_NULL               { $$ = null; }
         ;

raw_string : TOKEN_STRING_DQ          { $$ = substr($1, 1, -1); }
           | TOKEN_STRING_SQ          { $$ = substr($1, 1, -1); }
           ;

whitespace : whitespace TOKEN_WHITESPACE
           | TOKEN_WHITESPACE
           ;

optional_whitespace : whitespace
                    | /* empty */
                    ;

// -----------------------------------------------------------------------------

xhp_tag:
    T_XHP_TAG_LT
    T_XHP_LABEL
    xhp_tag_body
    T_XHP_TAG_GT                       { xhp_tag(_p,$$,$2,$3);}
;
xhp_tag_body:
    xhp_attributes '/'                 { Token t1; _p->onDArray(t1,$1);
                                         Token t2; _p->onVArray(t2,$2);
                                         Token file; scalar_file(_p, file);
                                         Token line; scalar_line(_p, line);
                                         _p->onCallParam($1,NULL,t1,
                                                         ParamMode::In,0);
                                         _p->onCallParam($$, &$1,t2,
                                                         ParamMode::In,0);
                                         _p->onCallParam($1, &$1,file,
                                                         ParamMode::In,0);
                                         _p->onCallParam($1, &$1,line,
                                                         ParamMode::In,0);
                                         $$.setText("");}
  | xhp_attributes T_XHP_TAG_GT
    xhp_children T_XHP_TAG_LT '/'
    xhp_opt_end_label                  { Token file; scalar_file(_p, file);
                                         Token line; scalar_line(_p, line);
                                         _p->onDArray($4,$1);
                                         _p->onVArray($5,$3);
                                         _p->onCallParam($2,NULL,$4,
                                                         ParamMode::In,0);
                                         _p->onCallParam($$, &$2,$5,
                                                         ParamMode::In,0);
                                         _p->onCallParam($2, &$2,file,
                                                         ParamMode::In,0);
                                         _p->onCallParam($2, &$2,line,
                                                         ParamMode::In,0);
                                         $$.setText($6.text());}
;
xhp_opt_end_label:
                                       { $$.reset(); $$.setText("");}
  | T_XHP_LABEL                        { $$.reset(); $$.setText($1);}
;
xhp_attributes:
                                       { _p->onXhpAttributesStart(); $$.reset();}
  | xhp_attributes
    '{' T_ELLIPSIS expr '}'            { _p->onXhpAttributeSpread($$, &$1, $4);}
  | xhp_attributes
    xhp_attribute_name '='
    xhp_attribute_value                { _p->onArrayPair($$,&$1,&$2,&$4,0);}
;
xhp_children:
xhp_children xhp_child                 { _p->onOptExprListElem($$, &$1, $2); }
  |                                    {  $$.reset();}
;
xhp_attribute_name:
    T_XHP_LABEL                        { _p->onScalar($$,
                                         T_CONSTANT_ENCAPSED_STRING, $1);}
;
xhp_attribute_value:
    T_XHP_TEXT                         { $1.xhpDecode();
                                         _p->onScalar($$,
                                         T_CONSTANT_ENCAPSED_STRING, $1);}
  | '{' expr '}'                       { $$ = $2;}
;
xhp_child:
    T_XHP_TEXT                         { $$.reset();
                                         if ($1.htmlTrim()) {
                                           $1.xhpDecode();
                                           _p->onScalar($$,
                                           T_CONSTANT_ENCAPSED_STRING, $1);
                                         }
                                       }
  | '{' expr '}'                       { $$ = $2; }
  | xhp_tag                            { $$ = $1; }
;

xhp_label_ws:
    xhp_bareword                       { $$ = $1;}
  | xhp_label_ws ':'
    xhp_bareword                       { $$ = $1 + ":" + $3;}
  | xhp_label_ws '-'
    xhp_bareword                       { $$ = $1 + "-" + $3;}
;

xhp_bareword:
    ident_no_semireserved              { $$ = $1;}
  | T_EXIT                             { $$ = $1;}
  | T_FUNCTION                         { $$ = $1;}
  | T_CONST                            { $$ = $1;}
  | T_RETURN                           { $$ = $1;}
  | T_YIELD                            { $$ = $1;}
  | T_YIELD_FROM                       { $$ = $1;}
  | T_AWAIT                            { $$ = $1;}
  | T_TRY                              { $$ = $1;}
  | T_CATCH                            { $$ = $1;}
  | T_FINALLY                          { $$ = $1;}
  | T_THROW                            { $$ = $1;}
  | T_IF                               { $$ = $1;}
  | T_ELSEIF                           { $$ = $1;}
  | T_ENDIF                            { $$ = $1;}
  | T_ELSE                             { $$ = $1;}
  | T_WHILE                            { $$ = $1;}
  | T_ENDWHILE                         { $$ = $1;}
  | T_DO                               { $$ = $1;}
  | T_FOR                              { $$ = $1;}
  | T_ENDFOR                           { $$ = $1;}
  | T_FOREACH                          { $$ = $1;}
  | T_ENDFOREACH                       { $$ = $1;}
  | T_DECLARE                          { $$ = $1;}
  | T_ENDDECLARE                       { $$ = $1;}
  | T_INSTANCEOF                       { $$ = $1;}
  | T_AS                               { $$ = $1;}
  | T_SWITCH                           { $$ = $1;}
  | T_ENDSWITCH                        { $$ = $1;}
  | T_CASE                             { $$ = $1;}
  | T_DEFAULT                          { $$ = $1;}
  | T_BREAK                            { $$ = $1;}
  | T_CONTINUE                         { $$ = $1;}
  | T_GOTO                             { $$ = $1;}
  | T_ECHO                             { $$ = $1;}
  | T_PRINT                            { $$ = $1;}
  | T_CLASS                            { $$ = $1;}
  | T_INTERFACE                        { $$ = $1;}
  | T_EXTENDS                          { $$ = $1;}
  | T_IMPLEMENTS                       { $$ = $1;}
  | T_NEW                              { $$ = $1;}
  | T_CLONE                            { $$ = $1;}
  | T_VAR                              { $$ = $1;}
  | T_EVAL                             { $$ = $1;}
  | T_INCLUDE                          { $$ = $1;}
  | T_INCLUDE_ONCE                     { $$ = $1;}
  | T_REQUIRE                          { $$ = $1;}
  | T_REQUIRE_ONCE                     { $$ = $1;}
  | T_NAMESPACE                        { $$ = $1;}
  | T_USE                              { $$ = $1;}
  | T_GLOBAL                           { $$ = $1;}
  | T_ISSET                            { $$ = $1;}
  | T_EMPTY                            { $$ = $1;}
  | T_HALT_COMPILER                    { $$ = $1;}
  | T_STATIC                           { $$ = $1;}
  | T_ABSTRACT                         { $$ = $1;}
  | T_FINAL                            { $$ = $1;}
  | T_PRIVATE                          { $$ = $1;}
  | T_PROTECTED                        { $$ = $1;}
  | T_PUBLIC                           { $$ = $1;}
  | T_ASYNC                            { $$ = $1;}
  | T_UNSET                            { $$ = $1;}
  | T_LIST                             { $$ = $1;}
  | T_ARRAY                            { $$ = $1;}
  | T_LOGICAL_OR                       { $$ = $1;}
  | T_LOGICAL_AND                      { $$ = $1;}
  | T_LOGICAL_XOR                      { $$ = $1;}
  | T_CLASS_C                          { $$ = $1;}
  | T_FUNC_C                           { $$ = $1;}
  | T_METHOD_C                         { $$ = $1;}
  | T_LINE                             { $$ = $1;}
  | T_FILE                             { $$ = $1;}
  | T_DIR                              { $$ = $1;}
  | T_NS_C                             { $$ = $1;}
  | T_COMPILER_HALT_OFFSET             { $$ = $1;}
  | T_TRAIT                            { $$ = $1;}
  | T_TRAIT_C                          { $$ = $1;}
  | T_INSTEADOF                        { $$ = $1;}
  | T_TYPE                             { $$ = $1;}
  | T_NEWTYPE                          { $$ = $1;}
  | T_SHAPE                            { $$ = $1;}
  | T_USING                            { $$ = $1;}
  | T_INOUT                            { $$ = $1;}
  | T_FUNC_CRED_C                      { $$ = $1;}
;


expr:
    expr_no_variable                   { $$ = $1;}
  | variable                           { $$ = $1;}
  | expr_with_parens                   { $$ = $1;}
  | lambda_or_closure                  { $$ = $1;}
  | lambda_or_closure_with_parens      { $$ = $1;}
;

lambda_or_closure_with_parens:
    '(' lambda_or_closure ')'          { $$ = $2;}
;

lambda_or_closure:
    closure_expression                 { $$ = $1;}
  | lambda_expression                  { $$ = $1;}
;

expr_with_parens:
    '(' expr_with_parens ')'           { $$ = $2;}
  | T_NEW class_name_reference
    ctor_arguments                     { _p->onNewObject($$, $2, $3);}
  | T_CLONE expr                       { UEXP($$,$2,T_CLONE,1);}
  | xhp_tag                            { $$ = $1;}
  | collection_literal                 { $$ = $1;}
  ;

expr_no_variable:
    array_literal
    '=' expr                           { _p->onListAssignment($$, $1, &$3);}
  | variable '=' expr                  { _p->onAssign($$, $1, $3, 0);}
  | variable '=' '&' variable          { _p->onAssign($$, $1, $4, 1);}
  | variable '=' '&' T_NEW
    class_name_reference
    ctor_arguments                     { _p->onAssignNew($$,$1,$5,$6);}
  | variable T_PLUS_EQUAL expr         { BEXP($$,$1,$3,T_PLUS_EQUAL);}
  | variable T_MINUS_EQUAL expr        { BEXP($$,$1,$3,T_MINUS_EQUAL);}
  | variable T_MUL_EQUAL expr          { BEXP($$,$1,$3,T_MUL_EQUAL);}
  | variable T_DIV_EQUAL expr          { BEXP($$,$1,$3,T_DIV_EQUAL);}
  | variable T_CONCAT_EQUAL expr       { BEXP($$,$1,$3,T_CONCAT_EQUAL);}
  | variable T_MOD_EQUAL expr          { BEXP($$,$1,$3,T_MOD_EQUAL);}
  | variable T_AND_EQUAL expr          { BEXP($$,$1,$3,T_AND_EQUAL);}
  | variable T_OR_EQUAL expr           { BEXP($$,$1,$3,T_OR_EQUAL);}
  | variable T_XOR_EQUAL expr          { BEXP($$,$1,$3,T_XOR_EQUAL);}
  | variable T_SL_EQUAL expr           { BEXP($$,$1,$3,T_SL_EQUAL);}
  | variable T_SR_EQUAL expr           { BEXP($$,$1,$3,T_SR_EQUAL);}
  | variable T_POW_EQUAL expr          { BEXP($$,$1,$3,T_POW_EQUAL);}
  | variable T_INC                     { UEXP($$,$1,T_INC,0);}
  | T_INC variable                     { UEXP($$,$2,T_INC,1);}
  | variable T_DEC                     { UEXP($$,$1,T_DEC,0);}
  | T_DEC variable                     { UEXP($$,$2,T_DEC,1);}
  | expr T_BOOLEAN_OR expr             { BEXP($$,$1,$3,T_BOOLEAN_OR);}
  | expr T_BOOLEAN_AND expr            { BEXP($$,$1,$3,T_BOOLEAN_AND);}
  | expr T_LOGICAL_OR expr             { BEXP($$,$1,$3,T_LOGICAL_OR);}
  | expr T_LOGICAL_AND expr            { BEXP($$,$1,$3,T_LOGICAL_AND);}
  | expr T_LOGICAL_XOR expr            { BEXP($$,$1,$3,T_LOGICAL_XOR);}
  | expr '|' expr                      { BEXP($$,$1,$3,'|');}
  | expr '&' expr                      { BEXP($$,$1,$3,'&');}
  | expr '^' expr                      { BEXP($$,$1,$3,'^');}
  | expr '.' expr                      { BEXP($$,$1,$3,'.');}
  | expr '+' expr                      { BEXP($$,$1,$3,'+');}
  | expr '-' expr                      { BEXP($$,$1,$3,'-');}
  | expr '*' expr                      { BEXP($$,$1,$3,'*');}
  | expr '/' expr                      { BEXP($$,$1,$3,'/');}
  | expr T_POW expr                    { BEXP($$,$1,$3,T_POW);}
  | expr '%' expr                      { BEXP($$,$1,$3,'%');}
  | expr T_PIPE expr                   { BEXP($$,$1,$3,T_PIPE);}
  | expr T_SL expr                     { BEXP($$,$1,$3,T_SL);}
  | expr T_SR expr                     { BEXP($$,$1,$3,T_SR);}
  | '+' expr %prec T_INC               { UEXP($$,$2,'+',1);}
  | '-' expr %prec T_INC               { UEXP($$,$2,'-',1);}
  | '!' expr                           { UEXP($$,$2,'!',1);}
  | '~' expr                           { UEXP($$,$2,'~',1);}
  | expr T_IS_IDENTICAL expr           { BEXP($$,$1,$3,T_IS_IDENTICAL);}
  | expr T_IS_NOT_IDENTICAL expr       { BEXP($$,$1,$3,T_IS_NOT_IDENTICAL);}
  | expr T_IS_EQUAL expr               { BEXP($$,$1,$3,T_IS_EQUAL);}
  | expr T_IS_NOT_EQUAL expr           { BEXP($$,$1,$3,T_IS_NOT_EQUAL);}
  | expr '<' expr                      { BEXP($$,$1,$3,'<');}
  | expr T_IS_SMALLER_OR_EQUAL expr    { BEXP($$,$1,$3,
                                              T_IS_SMALLER_OR_EQUAL);}
  | expr '>' expr                      { BEXP($$,$1,$3,'>');}
  | expr T_IS_GREATER_OR_EQUAL expr    { BEXP($$,$1,$3,
                                              T_IS_GREATER_OR_EQUAL);}
  | expr T_SPACESHIP expr              { BEXP($$,$1,$3,T_SPACESHIP);}
  | expr T_INSTANCEOF
    class_name_reference               { BEXP($$,$1,$3,T_INSTANCEOF);}
  | parenthesis_expr_no_variable       { $$ = $1;}
  | expr '?' expr ':' expr             { _p->onQOp($$, $1, &$3, $5);}
  | expr '?' ':' expr                  { _p->onQOp($$, $1,   0, $4);}
  | expr T_COALESCE expr               { _p->onNullCoalesce($$, $1, $3);}
  | internal_functions                 { $$ = $1;}
  | T_INT_CAST expr                    { UEXP($$,$2,T_INT_CAST,1);}
  | T_DOUBLE_CAST expr                 { UEXP($$,$2,T_DOUBLE_CAST,1);}
  | T_STRING_CAST expr                 { UEXP($$,$2,T_STRING_CAST,1);}
  | T_ARRAY_CAST expr                  { UEXP($$,$2,T_ARRAY_CAST,1);}
  | T_OBJECT_CAST expr                 { UEXP($$,$2,T_OBJECT_CAST,1);}
  | T_BOOL_CAST expr                   { UEXP($$,$2,T_BOOL_CAST,1);}
  | T_UNSET_CAST expr                  { UEXP($$,$2,T_UNSET_CAST,1);}
  | T_EXIT exit_expr                   { UEXP($$,$2,T_EXIT,1);}
  | '@' expr                           { UEXP($$,$2,'@',1);}
  | scalar                             { $$ = $1; }
  | array_literal                      { $$ = $1; }
  | dict_literal                       { $$ = $1; }
  | vec_literal                        { $$ = $1; }
  | keyset_literal                     { $$ = $1; }
  | varray_literal                     { $$ = $1; }
  | darray_literal                     { $$ = $1; }
  | tuple_literal                      { $$ = $1; }
  | shape_literal                      { $$ = $1; }
  | '`' backticks_expr '`'             { _p->onEncapsList($$,'`',$2);}
  | T_PRINT expr                       { UEXP($$,$2,T_PRINT,1);}
  | dim_expr                           { $$ = $1;}
;

variable:
    variable_no_objects                { $$ = $1;}
  | simple_function_call               { $$ = $1;}
  | object_method_call                 { $$ = $1;}
  | class_method_call                  { $$ = $1;}
  | dimmable_variable_access           { $$ = $1;}
  | object_property_access_on_expr     { $$ = $1;}
  | variable object_operator
    object_property_name            { _p->onObjectProperty(
                                        $$,
                                        $1,
                                        !$2.num()
                                          ? HPHP::PropAccessType::Normal
                                          : HPHP::PropAccessType::NullSafe,
                                        $3
                                      );
                                    }
  | static_class_name
    T_DOUBLE_COLON
    /* !PHP5_ONLY */
    variable_no_objects
    /* !END */
    /* !PHP7_ONLY */
    compound_variable
    /* !END */
                                       { _p->onStaticMember($$,$1,$3);}
  | callable_variable '('
    function_call_parameter_list ')'   { _p->onCall($$,1,$1,$3,NULL);}
  | lambda_or_closure_with_parens '('
    function_call_parameter_list ')'   { _p->onCall($$,1,$1,$3,NULL);}
  | '(' variable ')'                   { $$ = $2;}
;

%%


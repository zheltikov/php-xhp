%pure_parser
%expect 2

%tokens

%%

root : xhp_tag                          { $$ = $1; }
     ;

xhp_tag : TOKEN_ANGLE_LEFT TOKEN_TAG_NAME xhp_tag_body TOKEN_ANGLE_RIGHT
                                        { $$ = new XhpTag();
                                          $$->setName($2);
                                          $$->setBody($3); }
        ;

xhp_tag_body : xhp_attributes TOKEN_FORWARD_SLASH
                                        { $$ = new XhpAttributeList();
                                          $$->setAttributes($1); }

             | xhp_attributes TOKEN_ANGLE_RIGHT xhp_children TOKEN_ANGLE_LEFT
               TOKEN_FORWARD_SLASH TOKEN_TAG_NAME
                                        { $attribute_list = new XhpAttributeList();
                                          $attribute_list->setAttributes($1);
                                          $child_list = new XhpChildList();
                                          $child_list->setChildren($3);
                                          $$ = [
                                              'attributes' => $attribute_list,
                                              'children' => $child_list,
                                              'end_tag_name' => $6,
                                          ]; }
            ;

xhp_attributes : /* empty */            { $$ = []; }
               | xhp_attributes TOKEN_CURLY_START TOKEN_ELLIPSIS expr
                 TOKEN_CURLY_END
                                        { xhp_attribute_spread($$, $1, $4); }

               | xhp_attributes xhp_attribute_name TOKEN_EQUALS
                 xhp_attribute_value
                                        { xhp_add_attribute($$, $1, $2, $4); }
               ;

xhp_children : xhp_children xhp_child   { xhp_add_child($$, $1, $2); }
             | /* empty */              { $$ = []; }
             ;

xhp_attribute_name : TOKEN_ATTRIBUTE_NAME
                                        { $$ = $1; }
                   ;

xhp_attribute_value : TOKEN_ATTRIBUTE_VALUE
                                        { $$ = xhp_decode_attribute_value($1); }
                    | TOKEN_CURLY_START expr TOKEN_CURLY_END
                                        { $$ = $2; }
                    ;

xhp_child : TOKEN_XHP_TEXT              { $$ = xhp_decode_child_text($1); }
          | TOKEN_CURLY_START expr TOKEN_CURLY_END
                                        { $$ = $2; }
          | xhp_tag                     { $$ = $1; }
          ;

/* --- HERE --- */

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


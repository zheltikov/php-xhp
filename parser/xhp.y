%pure_parser
%expect 2

%tokens

%%

root : optional_whitespace xhp_tag optional_whitespace
                                        { $$ = $2; }
     ;

xhp_tag : TOKEN_ANGLE_LEFT TOKEN_TAG_NAME optional_whitespace xhp_tag_body
          TOKEN_ANGLE_RIGHT
                                        { $$ = new Node(Type::XHP_TAG());
                                          $$->setValue([
                                              // TODO: how to determine the filename?
                                              'filename' => 'unknown',
                                              'line' => $this->lexer->getLine(),
                                          ]);
                                          $tag_name = new Node(Type::XHP_TAG_NAME());
                                          $tag_name->setValue($2);
                                          $$->appendChild($tag_name);
                                          $closing_tag_name = $4->getValue();
                                          if (!array_key_exists('closing_tag_name', $closing_tag_name)) {
                                              throw new \RuntimeException('Expected `closing_tag_name` not found!');
                                          }
                                          $closing_tag_name = $closing_tag_name['closing_tag_name'];
                                          if ($closing_tag_name !== $2) {
                                              throw new \RuntimeException(
                                                  sprintf(
                                                      'Closing tag name mismatch: <%s>%s</%s>',
                                                      $2,
                                                      $4->hasChildren()
                                                      && $4->getChildAt(0)->hasChildren()
                                                          ? '...' : '',
                                                      $closing_tag_name
                                                  )
                                              );
                                          }
                                          $$->appendChild($4); }
        ;

xhp_tag_body : TOKEN_FORWARD_SLASH      { $$ = new Node(Type::XHP_TAG_BODY()); }

             | TOKEN_ANGLE_RIGHT xhp_children TOKEN_ANGLE_LEFT
               TOKEN_FORWARD_SLASH TOKEN_TAG_NAME
                                        { $$ = new Node(Type::XHP_TAG_BODY());
                                          $$->setValue([
                                              'closing_tag_name' => $5,
                                          ]);
                                          $$->appendChild($2); }
            ;

xhp_children : xhp_children xhp_child   { $$ = $1; $$->appendChild($2); }
             | /* empty */              { $$ = new Node(Type::CHILD_LIST()); }
             ;

xhp_child : xhp_tag                     { $$ = $1; }
          | TOKEN_WHITESPACE            { $$ = new Node(Type::WHITESPACE(), $1); }
          | xhp_text                    { $$ = $1; }
          | xhp_entity                  { $$ = $1; }
          ;

xhp_entity : TOKEN_XHP_ENTITY           { $$ = new Node(Type::XHP_ENTITY(), $1); }
           ;

xhp_text : TOKEN_XHP_TEXT               { $$ = new Node(Type::XHP_TEXT(), $1); }
         | TOKEN_TAG_NAME               { $$ = new Node(Type::XHP_TEXT(), $1); }
         ;

many_whitespace : many_whitespace TOKEN_WHITESPACE
                                        { $$ = $1;
                                          $$->setValue($1->getValue() . $2); }
                | TOKEN_WHITESPACE  { $$ = new Node(Type::WHITESPACE(), $1); }
                ;

required_whitespace : many_whitespace   { $$ = $1; }
                    ;

optional_whitespace : /* empty */       { $$ = new Node(Type::WHITESPACE(), ''); }
                    | many_whitespace   { $$ = $1; }
                    ;

%%


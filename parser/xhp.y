%pure_parser
%expect 2

%tokens

%%

root : xhp_tag                          { $$ = $1; }
     ;

xhp_tag : TOKEN_ANGLE_LEFT TOKEN_TAG_NAME xhp_tag_body TOKEN_ANGLE_RIGHT
                                        { $$ = new Node(Type::XHP_TAG());
                                          $tag_name = new Node(Type::XHP_TAG_NAME());
                                          $tag_name->setValue($2);
                                          $$->appendChild($tag_name);
                                          $$->appendChild($3); }
        ;

xhp_tag_body : TOKEN_FORWARD_SLASH      { $$ = new Node(Type::XHP_TAG_BODY()); }

             | TOKEN_ANGLE_RIGHT TOKEN_ANGLE_LEFT TOKEN_FORWARD_SLASH TOKEN_TAG_NAME
                                        { $$ = new Node(Type::XHP_TAG_BODY());
                                          $$->setValue([
                                              'closing_tag_name' => $4,
                                          ]); }
            ;

%%


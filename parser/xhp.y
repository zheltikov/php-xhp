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

xhp_tag_body : TOKEN_FORWARD_SLASH      { $$ = new XhpTagBody();
                                          $$->setAttributes(null); }

             | TOKEN_ANGLE_RIGHT TOKEN_ANGLE_LEFT TOKEN_FORWARD_SLASH TOKEN_TAG_NAME
                                        { $$ = new XhpTagBody();
                                          $$->setAttributes(null);
                                          $$->setChildren(null);
                                          $$->setClosingTagName($4); }
            ;

%%


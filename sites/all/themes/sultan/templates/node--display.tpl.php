
                        <div  class="view-prod">
                            <div class="prw">
                              <?php print render($content['product:field_product_photos']); ?>
                            </div>
                            <div class="product-descr">
                            
                                <div class="price">
                                  <?php print render($content['product:commerce_price']); ?>
                                </div>
                                
                                <div class="status">
                                  <?php print render($content['product:field_available']); ?>
                                </div>
                                
                                <div class="color-prod">
                                    <?php print render($content['field_product_ref']); ?>
                                </div>

                                <div>
                                  <p>
                                    <?php if (isset($content['body']['#title'])): ?>
                                      <strong>
                                        <?php print $content['body']['#object']->title . ' ' . t('description:') ; ?>
                                      </strong><br>
                                      <?php print render($content['body']); ?>
                                    <?php endif; ?>
                                    </p>
                                </div>  
                                
                                <div class="share-link">
                                  <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                                  <div class="yashare-auto-init" data-yashareL10n="ru"
                                   data-yashareType="none" data-yashareQuickServices="facebook,vkontakte,gplus">
                                 </div>
                                </div>
                                
                            </div>
                        </div>
<section id="partner">
							<div class="container section4">
								<div class="row">
									<div class="partner">
										<div class="col-md-12">
											<div class="title2">
												<div class="divder"></div>
												<h2>Partenaires</h2>
											</div>
											<?php 
											$req = $my->req('SELECT * FROM ttre_diaporama ');
											if ( $my->num($req)>0 )
											{
												echo'<div id="owl-demo">';
												while ( $res=$my->arr($req) )
												{
													$photo='upload/diaporamas/_no_2.jpg';
													if ( !empty($res['photo']) ) $photo='upload/diaporamas/150X150/'.$res['photo'];
													echo'
														<div class="item"><a target="_blanc" href="'.$res['lien'].'"><img src="'.$photo.'" alt="'.$res['titre'].'"/></a></div>
														';
												}
												echo'</div>';
											}
											?>	
											</div>
										</div>
								</div>
							</div>
						</section>
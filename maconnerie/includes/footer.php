<footer>
    <div class="footer-section">
        <div class="overlay5"></div>
            <div class="container">
                <div class="row">
                    <div class="categories">
                        <div class="col-md-2">
                            <a href="#">
                                <div class="category" >
                                    <div class="cat-icon">
                                        <img src="../images/icons/Maconnorie.png" alt="Maçonnerie">
                                    </div>
                                    <span>Maçonnorie</span>
                                </div>
                                <div class="overlay4"></div> 
                            </a>

                            <a href="#">
                                <div class="category" >
                                    <div class="cat-icon">
                                        <img src="../images/icons/Menuiserie.png" alt="Menuiserie">
                                    </div>
                                    <span>Menuiserie</span>
                                </div>
                                <div class="overlay4"></div> 
                            </a>				
                        </div>

                        <div class="col-md-2">
                            <a href="#">
                                <div class="category" >
                                    <div class="cat-icon">
                                        <img src="../images/icons/sol.png" alt="revêtement de sol">
                                    </div>
                                    <span>Revêtement de sol</span>
                                </div>
                                <div class="overlay4"></div> 
                            </a>

                            <a href="#">
                                <div class="category" >
                                    <div class="cat-icon">
                                        <img src="../images/icons/Murs.png" alt="Revêtement de murs et plafond">
                                    </div>
                                    <span>Murs et Plafond</span>
                                </div>
                                <div class="overlay4"></div> 
                            </a>		
                        </div>

                        <div class="col-md-2">
                            <a href="#">
                                <div class="category" >
                                    <div class="cat-icon">
                                        <img src="../images/icons/Plomberie.png" alt="Plomberie">
                                    </div>
                                    <span>Plomberie</span>
                                </div>
                                <div class="overlay4"></div> 
                            </a>        		
                            <a href="#">
                                <div class="category" >
                                    <div class="cat-icon">
                                        <img src="../images/icons/Electricite.png" alt="Electricite">
                                    </div>
                                    <span>Electricité</span>
                                </div>
                                <div class="overlay4"></div> 
                            </a>			
                        </div>   
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <div class="widget">
                            <div class="divider"></div>
                            <h3>Tousrenov.fr</h3>
                            <p>
            En conformité avec la loi Informatique et liberté du 6 janvier 1978, TousRenov est enregistré auprès des services de la CNIL sous le n° 1928302V0. En application de la loi Informatique et Liberté, vous disposez à tout moment d'un droit d'accès et de modification sur les données personnelles vous concernant.
                            </p>
        <!-- SOCIAL MEDIA FOOTER -->
        <div class="footer-social-media">
        <ul>
            <li>
                <a href="https://www.facebook.com/tousrenovpro" title="Like Us">
                    <span class="fa fa-facebook"></span>
                </a>
            </li>
            <li>
                <a href="https://twitter.com/tousrenov1" title="Follow Me on Twitter">
                    <span class="fa fa-twitter"></span>
                </a>
            </li>
            <li>
                <a href="https://plus.google.com/u/0/+devistravauxmaisontrouvezlemeilleurartisantousreno" title="Follow Me on Twitter">
                    <span class="fa fa-google-plus"></span>
                </a>
            </li>
            <li>
                <a href="https://www.linkedin.com/profile/view?id=253312067" title="Follow Me on Twitter">
                    <span class="fa fa-linkedin"></span>
                </a>
            </li>
            <li>
                <a href="https://www.youtube.com/channel/UCzPvAqbAK23sa0HguRFPaIg" title="">
                    <span class="fa fa-youtube"></span>
                </a>
            </li>
            <li>
                <a href="http://fr.viadeo.com/fr/profile/tousrenov.renovation.interieur">
                    <span class="viadeo"><img src="../images/viadeo.png" alt="Tousrenov Viadeo">
                    </span>
                </a>
            </li>
        </ul>
        </div>
        <!-- END SOCIAL MEDIA FOOTER -->
                        </div>
            </div>
            </div>
        </div>
    </div>     	        	
</footer>
        
        <!-- Javascript -->
        <script src="js/scripts.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.backstretch.min.js"></script>
        <script src="js/retina-1.1.0.min.js"></script>
        <script src="js/jquery.datetimepicker.full.js"></script>
        

        <script type="text/javascript">

            $(document).ready(function() {
               $('input[type="radio"]').click(function() {
                   if($(this).attr('id') == 'spec_4') {
                        $('.content').show('slow');   
                        $("#percisez").prop("required", true);
                        $("#percisez").prop("disabled", false);        
                   }
                   else {
                        $('.content').hide('slow');   
                        $("#percisez").prop("required", false);
                        $("#percisez").prop("disabled", true);             
                   }
               });
            });

            $(document).ready(function(){
              $("#spec_4").click(function (){

                // get the value of this radio button ("dollars" or "percent")
                var value = $(this).val();
                // find all text fields...
                $(this).closest(".types").find("input[type=text]")
                  // ...and disable them...
                  .attr("disabled")                     
                // ...then find the text field whose class name matches
                // the value of this radio button ("dollars" or "percent")...
                .end().find("." + value)
                  // ...and enable that text field
                  .removeAttr("disabled")          
                .end();
              });
            });

        </script>
        
        <!-- DATE PICKER SCRIPT -->
        <?php include_once('includes/datepicker.php'); ?>

    </body>        
</htlml>
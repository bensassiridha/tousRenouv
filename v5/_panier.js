function function_modif_panier(idC,idQ)
{
	//alert("idC="+idC+";idQ="+idQ);
	if( ! isNaN($.trim($("#quest_"+idQ+"").val())) )
	{
		// 1 - 1 - Maçonnerie --------------- Mur --------------
		// 1 - 2 - Maçonnerie --------------- Construction --------------
		// 1 - 3 - Maçonnerie --------------- Isolation --------------
		if ( idQ==151 )
		{
			if ( $("#quest_151").val()==214 ) 
			{
				$("#suite_quest_152").css('display','');
				$("#suite_quest_153").css('display','none');
			}
			else if ( $("#quest_151").val()==215 || $("#quest_151").val()==216 ) 
			{
				$("#suite_quest_152").css('display','none');
				$("#suite_quest_153").css('display','');
			}
			else 
			{
				$("#suite_quest_152").css('display','none');
				$("#suite_quest_153").css('display','none');
			}
		}
		// 1 - 4 - Maçonnerie --------------- Terrassement --------------
		// 1 - 5 - Maçonnerie --------------- Couverture --------------
		// 2 - 1 - Menuiserie --------------- Fenêtre --------------
		// 2 - 2 - Menuiserie --------------- Volet --------------
		// 2 - 3 - Menuiserie --------------- Porte-fenêtre --------------
		// 2 - 4 - Menuiserie --------------- Velux --------------
		// 2 - 5 - Menuiserie --------------- Autre --------------
		// 3 - 1 - Revêtement de sol --------------- carrelage --------------
		else if ( idQ==18 )
		{
			if ( $("#quest_18").val()==253 ) 
			{
				$("#suite_quest_19").css('display','');
			}
			else if ( $("#quest_18").val()==254 || $("#quest_18").val()==0) 
			{
				$("#suite_quest_19").css('display','none');
			}
		}
		// 3 - 2 - Revêtement de sol --------------- Parquet --------------
		else if ( idQ==26 )
		{
			if ( $("#quest_26").val()==38 ) 
			{
				$("#suite_quest_173").css('display','');
			}
			else if ( $("#quest_26").val()==39 || $("#quest_26").val()==0) 
			{
				$("#suite_quest_173").css('display','none');
			}
		}
		// 3 - 3 - Revêtement de sol --------------- Extérieur --------------
		else if ( idQ==27 )
		{
			if ( $("#quest_27").val()==41 ) 
			{
				$("#suite_quest_28").css('display','');
			}
			else if ( $("#quest_27").val()==42 || $("#quest_27").val()==0) 
			{
				$("#suite_quest_28").css('display','none');
			}
		}
		else if ( idQ==182 )
		{
			if ( $("#quest_182").val()==293 ) 
			{
				$("#suite_quest_183").css('display','');
			}
			else if ( $("#quest_182").val()==294 || $("#quest_182").val()==0) 
			{
				$("#suite_quest_183").css('display','none');
			}
		}
		// 3 - 4 - Revêtement de sol --------------- Moquette --------------
		else if ( idQ==29 )
		{
			if ( $("#quest_29").val()==44 ) 
			{
				$("#suite_quest_30").css('display','');
			}
			else if ( $("#quest_29").val()==45 || $("#quest_29").val()==0) 
			{
				$("#suite_quest_30").css('display','none');
			}
		}
		// 3 - 5 - Revêtement de sol --------------- Sol plastique --------------
		else if ( idQ==31 )
		{
			if ( $("#quest_31").val()==329 ) 
			{
				$("#suite_quest_196").css('display','');
			}
			else if ( $("#quest_31").val()==330 || $("#quest_31").val()==0) 
			{
				$("#suite_quest_196").css('display','none');
			}
		}
		// 3 - 6 - Revêtement de sol --------------- Autes finitions --------------
		// 4 - 1 - Revêtement de murs et plafond --------------- Murs intérieur --------------
		else if ( idQ==7 )
		{
			if ( $("#quest_7").val()==355 ) 
			{
				$("#suite_quest_9").css('display','');
				$("#suite_quest_10").css('display','none');
			}
			else if ( $("#quest_7").val()==356 ) 
			{
				$("#suite_quest_9").css('display','none');
				$("#suite_quest_10").css('display','');
			}
			else if ( $("#quest_7").val()==0 ) 
			{
				$("#suite_quest_9").css('display','none');
				$("#suite_quest_10").css('display','none');
			}
		}
		// 4 - 2 - Revêtement de murs et plafond --------------- Plafond --------------
		else if ( idQ==11 )
		{
			if ( $("#quest_11").val()==17 ) 
			{
				$("#suite_quest_12").css('display','');
				$("#suite_quest_210").css('display','none');
			}
			else if ( $("#quest_11").val()==18 ) 
			{
				$("#suite_quest_12").css('display','none');
				$("#suite_quest_210").css('display','');
			}
			else if ( $("#quest_11").val()==0 ) 
			{
				$("#suite_quest_12").css('display','none');
				$("#suite_quest_210").css('display','none');
			}
		}
		// 4 - 3 - Revêtement de murs et plafond --------------- Portes et fenetres --------------
		// 4 - 4 - Revêtement de murs et plafond --------------- Radiateurs --------------
		// 4 - 5 - Revêtement de murs et plafond --------------- Extérieur --------------
		// 5 - 1 - Plomberie --------------- Douche --------------
		else if ( idQ==100 )
		{
			if ( $("#quest_100").val()==145 ) 
			{
				$("#suite_quest_100").css('display','');
			}
			else if ( $("#quest_100").val()==144 ) 
			{
				$("#suite_quest_100").css('display','none');
			}
			else 
			{
				$("#suite_quest_100").css('display','none');
			}
		}
		// 5 - 2 - Plomberie --------------- Baignoire --------------
		else if ( idQ==107 )
		{
			if ( $("#quest_107").val()==149 ) 
			{
				$("#suite_quest_107").css('display','');
			}
			else if ( $("#quest_107").val()==148 ) 
			{
				$("#suite_quest_107").css('display','none');
			}
			else 
			{
				$("#suite_quest_107").css('display','none');
			}
		}
		// 5 - 3 - Plomberie --------------- Evier --------------
		else if ( idQ==113 )
		{
			if ( $("#quest_113").val()==153 ) 
			{
				$("#suite_quest_113").css('display','');
			}
			else if ( $("#quest_113").val()==152 ) 
			{
				$("#suite_quest_113").css('display','none');
			}
			else 
			{
				$("#suite_quest_113").css('display','none');
			}
		}
		// 5 - 4 - Plomberie --------------- WC --------------
		else if ( idQ==119 )
		{
			if ( $("#quest_119").val()==157 ) 
			{
				$("#suite_quest_119").css('display','');
			}
			else if ( $("#quest_119").val()==156 ) 
			{
				$("#suite_quest_119").css('display','none');
			}
			else 
			{
				$("#suite_quest_119").css('display','none');
			}
		}
		// 5 - 5 - Plomberie --------------- Chauffage --------------
		else if ( idQ==130 )
		{
			if ( $("#quest_130").val()==177 || $("#quest_130").val()==178 || $("#quest_130").val()==179 ) 
			{
				$("#suite_quest_131").css('display','');
			}
			else if ( $("#quest_130").val()==180 ) 
			{
				$("#suite_quest_131").css('display','none');
			}
			else 
			{
				$("#suite_quest_131").css('display','none');
			}
		}
		// 5 - 6 - Plomberie --------------- Autre --------------
		else if ( idQ==133 )
		{
			if ( $("#quest_133").val()==186 ) 
			{
				$("#suite_quest_133").css('display','');
			}
			else if ( $("#quest_133").val()==185 ) 
			{
				$("#suite_quest_133").css('display','none');
			}
			else 
			{
				$("#suite_quest_133").css('display','none');
			}
		}
		else if ( idQ==136 )
		{
			if ( $("#quest_136").val()==187 || $("#quest_136").val()==188 ) 
			{
				$("#suite_quest_136_1").css('display','');
				$("#suite_quest_136_2").css('display','none');
				$("#suite_quest_136_3").css('display','none');
			}
			else if ( $("#quest_136").val()==189 || $("#quest_136").val()==190 ) 
			{
				$("#suite_quest_136_1").css('display','none');
				$("#suite_quest_136_2").css('display','');
				$("#suite_quest_136_3").css('display','none');
			}
			else if ( $("#quest_136").val()==191 ) 
			{
				$("#suite_quest_136_1").css('display','none');
				$("#suite_quest_136_2").css('display','none');
				$("#suite_quest_136_3").css('display','');
			}
			else 
			{
				$("#suite_quest_136_1").css('display','none');
				$("#suite_quest_136_2").css('display','none');
				$("#suite_quest_136_3").css('display','none');
			}
		}
		// 6 - 1 - Electricité --------------- Prises --------------
		// 6 - 2 - Electricité --------------- Eclairage --------------
		// 6 - 3 - Electricité --------------- Tableau --------------
	}
}

//***************************************************************************************************************************************************

function ___function_modif_panier(idC,idQ)
{
	//alert("idC="+idC+";idQ="+idQ);
	if( ! isNaN($.trim($("#quest_"+idQ+"").val())) )
	{
		// Partie Maçonnerie --------------- Mur --------------
		if ( idQ==59 ) 
		{  
			if ( $("#quest_59").val()==0 )
			{
				if ( $("#quest_61").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_59_61").html();
					prixAncienCat=$("#prixCateg_1").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_59_61").html('Donner plus de précisions, en répondant aux questions pour la partie : Maçonnerie, mur');
					$("#tdUniteQuest_59_61").html('');
					$("#tdQteQuest_59_61").html('0.00');
					$("#tdPrixUniQuest_59_61").html('0.00');
					$("#tdPrixQuest_59_61").html('0.00');
				}
			}
			else
			{
				if ( $("#quest_61").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_1").html(); 
					prixAncienQuest=$("#tdPrixQuest_59_61").html();
					if ( $("#quest_59").val()==71 ) { prixUnitaire=100;prixQuest=(prixUnitaire*$("#quest_61").val());text='Fourniture et pose d\'un mur en briques'; }
					else if ( $("#quest_59").val()==72 ) { prixUnitaire=60;prixQuest=(prixUnitaire*$("#quest_61").val());text='Fourniture et pose d\'un mur en parpaing'; }
					else if ( $("#quest_59").val()==73 ) { prixUnitaire=110;prixQuest=(prixUnitaire*$("#quest_61").val());text='Fourniture et pose d\'un mur en béton cellulaire'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_59_61").html(text);
					$("#tdUniteQuest_59_61").html('m²');
					$("#tdQteQuest_59_61").html(number_format($("#quest_61").val(),2,'.',''));
					$("#tdPrixUniQuest_59_61").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_59_61").html(number_format(prixQuest,2,'.',''));
				}
			}
		}
		else if ( idQ==61 )
		{
			if ( $("#panier_1").html()=="" )
			{
				if ( $("#quest_61").val() )
				{
					if ( $("#quest_59").val()==0 )
					{
						$("#panier_1").css('display','');
						$("#panier_1").append('<tr id="trCat_1" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_1" class="n">0</th></tr>');
						$("#panier_1").append('<tr id="trQuest_59_61"><td id="tdLabelQuest_59_61">Donner plus de précisions, en répondant aux questions pour la partie : Maçonnerie, mur</td><td id="tdUniteQuest_59_61"></td><td id="tdQteQuest_59_61" class="n">0.00</td><td id="tdPrixUniQuest_59_61" class="n">0.00</td><td id="tdPrixQuest_59_61" class="n">0.00</td></tr>');
					}
					else
					{
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_59").val()==71 ) { prixUnitaire=100;prixQuest=(prixUnitaire*$("#quest_61").val());text='Fourniture et pose d\'un mur en briques'; }
						else if ( $("#quest_59").val()==72 ) { prixUnitaire=60;prixQuest=(prixUnitaire*$("#quest_61").val());text='Fourniture et pose d\'un mur en parpaing'; }
						else if ( $("#quest_59").val()==73 ) { prixUnitaire=110;prixQuest=(prixUnitaire*$("#quest_61").val());text='Fourniture et pose d\'un mur en béton cellulaire'; }
						prixCat=prixQuest;
						totalHT=(totalHTancien*1)+prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#panier_1").css('display','');
						$("#panier_1").append('<tr id="trCat_1" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_1" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
						$("#panier_1").append('<tr id="trQuest_59_61"><td id="tdLabelQuest_59_61">'+text+'</td><td id="tdUniteQuest_59_61">m²</td><td id="tdQteQuest_59_61" class="n">'+number_format($("#quest_61").val(),2,'.','')+'</td><td id="tdPrixUniQuest_59_61" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_59_61" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
					}
				}
			}
			else
			{
				if ( $("#quest_61").val() )
				{
					if ( $("#quest_59").val()!=0 )
					{
						prixAncienCat=$("#prixCateg_1").html(); 
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_59").val()==71 ) { prixUnitaire=100;prixQuest=(prixUnitaire*$("#quest_61").val());text='Fourniture et pose d\'un mur en briques'; }
						else if ( $("#quest_59").val()==72 ) { prixUnitaire=60;prixQuest=(prixUnitaire*$("#quest_61").val());text='Fourniture et pose d\'un mur en parpaing'; }
						else if ( $("#quest_59").val()==73 ) { prixUnitaire=110;prixQuest=(prixUnitaire*$("#quest_61").val());text='Fourniture et pose d\'un mur en béton cellulaire'; }
						if ( $("#trQuest_59_61").size()==0 )
						{
							prixCat=(prixAncienCat*1) + prixQuest;
							totalHT=(totalHTancien*1) + prixQuest;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
							$("#panier_1").append('<tr id="trQuest_59_61"><td id="tdLabelQuest_59_61">'+text+'</td><td id="tdUniteQuest_59_61">m²</td><td id="tdQteQuest_59_61" class="n">'+number_format($("#quest_61").val(),2,'.','')+'</td><td id="tdPrixUniQuest_59_61" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_59_61" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
						}
						else
						{
							prixAncienQuest=$("#tdPrixQuest_59_61").html();
							prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
							totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
							$("#tdQteQuest_59_61").html(number_format($("#quest_61").val(),2,'.',''));
							$("#tdPrixQuest_59_61").html(number_format(prixQuest,2,'.',''));
						}
					}
					else
					{
						if ( $("#trQuest_59_61").size()==0 )
						{
							$("#panier_1").append('<tr id="trQuest_59_61"><td id="tdLabelQuest_59_61">Donner plus de précisions, en répondant aux questions pour la partie : Maçonnerie, mur</td><td id="tdUniteQuest_59_61"></td><td id="tdQteQuest_59_61" class="n">0.00</td><td id="tdPrixUniQuest_59_61" class="n">0.00</td><td id="tdPrixQuest_59_61" class="n">0.00</td></tr>');
						}
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_1").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_59_61").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
					$("#trQuest_59_61").remove();
					if ( $("#panier_1").html()=='<tr id="trCat_1" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_1" class="n">0.00</th></tr>' ) 
						$("#trCat_1").remove();
				}
			}
		}
		else if ( idQ==62 )
		{
			if ( $("#panier_1").html()=="" )
			{
				totalHTancien=$("#totalHT").html();
				prixUnitaire=150;
				text='Fourniture et pose d\'un mur de soutènement en béton banché avec fondations';
				prixQuest=(prixUnitaire*$("#quest_62").val());
				prixCat=prixQuest;
				totalHT=(totalHTancien*1)+prixQuest;
				totalTVA=totalHT*19.6/100;
				totalTTC=totalHT+totalTVA;
				$("#totalHT").html(number_format(totalHT,2,'.',''));
				$("#totalTVA").html(number_format(totalTVA,2,'.',''));
				$("#totalTTC").html(number_format(totalTTC,2,'.',''));
				$("#panier_1").css('display','');
				$("#panier_1").append('<tr id="trCat_1" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_1" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
				$("#panier_1").append('<tr id="trQuest_62"><td id="tdLabelQuest_62">'+text+'</td><td id="tdUniteQuest_62">m²</td><td id="tdQteQuest_62" class="n">'+number_format($("#quest_62").val(),2,'.','')+'</td><td id="tdPrixUniQuest_62" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_62" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
			}
			else
			{
				if ( $("#quest_62").val() )
				{
					prixAncienCat=$("#prixCateg_1").html(); 
					totalHTancien=$("#totalHT").html();
					prixUnitaire=150;
					text='Fourniture et pose d\'un mur de soutènement en béton banché avec fondations';
					prixQuest=(prixUnitaire*$("#quest_62").val());
					if ( $("#trQuest_62").size()==0 )
					{
						prixCat=(prixAncienCat*1) + prixQuest;
						totalHT=(totalHTancien*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
						$("#panier_1").append('<tr id="trQuest_62"><td id="tdLabelQuest_62">'+text+'</td><td id="tdUniteQuest_62">m²</td><td id="tdQteQuest_62" class="n">'+number_format($("#quest_62").val(),2,'.','')+'</td><td id="tdPrixUniQuest_62" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_62" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
					}
					else
					{
						prixAncienQuest=$("#tdPrixQuest_62").html();
						prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
						totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
						$("#tdQteQuest_62").html(number_format($("#quest_62").val(),2,'.',''));
						$("#tdPrixQuest_62").html(number_format(prixQuest,2,'.',''));
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_1").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_62").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
					$("#trQuest_62").remove();
					if ( $("#panier_1").html()=='<tr id="trCat_1" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_1" class="n">0.00</th></tr>' ) 
						$("#trCat_1").remove();
				}
			}
		}
		// Partie Maçonnerie --------------- Ouverture mur porteur --------------
		else if ( idQ==63 )
		{
			if ( $("#panier_1").html()=="" )
			{
				totalHTancien=$("#totalHT").html();
				prixUnitaire=1400;
				text='Ouverture dans un mur en porteur, avec pose IPN';
				prixQuest=(prixUnitaire*parseInt($("#quest_63").val()));
				prixCat=prixQuest;
				totalHT=(totalHTancien*1)+prixQuest;
				totalTVA=totalHT*19.6/100;
				totalTTC=totalHT+totalTVA;
				$("#totalHT").html(number_format(totalHT,2,'.',''));
				$("#totalTVA").html(number_format(totalTVA,2,'.',''));
				$("#totalTTC").html(number_format(totalTTC,2,'.',''));
				$("#panier_1").css('display','');
				$("#panier_1").append('<tr id="trCat_1" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_1" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
				$("#panier_1").append('<tr id="trQuest_63"><td id="tdLabelQuest_63">'+text+'</td><td id="tdUniteQuest_63">unité</td><td id="tdQteQuest_63" class="n">'+number_format(parseInt($("#quest_63").val()),2,'.','')+'</td><td id="tdPrixUniQuest_63" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_63" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
			}
			else
			{
				if ( $("#quest_63").val() )
				{
					prixAncienCat=$("#prixCateg_1").html(); 
					totalHTancien=$("#totalHT").html();
					prixUnitaire=1400;
					text='Ouverture dans un mur en porteur, avec pose IPN';
					prixQuest=prixUnitaire*parseInt($("#quest_63").val());
					if ( $("#trQuest_63").size()==0 )
					{
						prixCat=(prixAncienCat*1) + prixQuest;
						totalHT=(totalHTancien*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
						$("#panier_1").append('<tr id="trQuest_63"><td id="tdLabelQuest_63">'+text+'</td><td id="tdUniteQuest_63">unité</td><td id="tdQteQuest_63" class="n">'+number_format(parseInt($("#quest_63").val()),2,'.','')+'</td><td id="tdPrixUniQuest_63" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_63" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
					}
					else
					{
						prixAncienQuest=$("#tdPrixQuest_63").html();
						prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
						totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
						$("#tdQteQuest_63").html(number_format(parseInt($("#quest_63").val()),2,'.',''));
						$("#tdPrixQuest_63").html(number_format(prixQuest,2,'.',''));
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_1").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_63").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
					$("#trQuest_63").remove();
					if ( $("#panier_1").html()=='<tr id="trCat_1" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_1" class="n">0.00</th></tr>' ) 
						$("#trCat_1").remove();
				}
			}
		}
		else if ( idQ==64 )
		{
			if ( $("#panier_1").html()=="" )
			{
				totalHTancien=$("#totalHT").html();
				prixUnitaire=700;
				text='Ouverture pour fenêtre dans un mur en porteur, avec pose de linteau';
				prixQuest=(prixUnitaire*parseInt($("#quest_64").val()));
				prixCat=prixQuest;
				totalHT=(totalHTancien*1)+prixQuest;
				totalTVA=totalHT*19.6/100;
				totalTTC=totalHT+totalTVA;
				$("#totalHT").html(number_format(totalHT,2,'.',''));
				$("#totalTVA").html(number_format(totalTVA,2,'.',''));
				$("#totalTTC").html(number_format(totalTTC,2,'.',''));
				$("#panier_1").css('display','');
				$("#panier_1").append('<tr id="trCat_1" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_1" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
				$("#panier_1").append('<tr id="trQuest_64"><td id="tdLabelQuest_64">'+text+'</td><td id="tdUniteQuest_64">unité</td><td id="tdQteQuest_64" class="n">'+number_format(parseInt($("#quest_64").val()),2,'.','')+'</td><td id="tdPrixUniQuest_64" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_64" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
			}
			else
			{
				if ( $("#quest_64").val() )
				{
					prixAncienCat=$("#prixCateg_1").html(); 
					totalHTancien=$("#totalHT").html();
					prixUnitaire=700;
					text='Ouverture pour fenêtre dans un mur en porteur, avec pose de linteau';
					prixQuest=prixUnitaire*parseInt($("#quest_64").val());
					if ( $("#trQuest_64").size()==0 )
					{
						prixCat=(prixAncienCat*1) + prixQuest;
						totalHT=(totalHTancien*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
						$("#panier_1").append('<tr id="trQuest_64"><td id="tdLabelQuest_64">'+text+'</td><td id="tdUniteQuest_64">unité</td><td id="tdQteQuest_64" class="n">'+number_format(parseInt($("#quest_64").val()),2,'.','')+'</td><td id="tdPrixUniQuest_64" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_64" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
					}
					else
					{
						prixAncienQuest=$("#tdPrixQuest_64").html();
						prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
						totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
						$("#tdQteQuest_64").html(number_format(parseInt($("#quest_64").val()),2,'.',''));
						$("#tdPrixQuest_64").html(number_format(prixQuest,2,'.',''));
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_1").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_64").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
					$("#trQuest_64").remove();
					if ( $("#panier_1").html()=='<tr id="trCat_1" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_1" class="n">0.00</th></tr>' ) 
						$("#trCat_1").remove();
				}
			}
		}
		// Partie Maçonnerie --------------- Dalle --------------
		else if ( idQ==65 )
		{
			if ( $("#panier_1").html()=="" )
			{
				totalHTancien=$("#totalHT").html();
				prixUnitaire=50;
				text='Fourniture et pose d\'une dalle en béton';
				prixQuest=(prixUnitaire*$("#quest_65").val());
				prixCat=prixQuest;
				totalHT=(totalHTancien*1)+prixQuest;
				totalTVA=totalHT*19.6/100;
				totalTTC=totalHT+totalTVA;
				$("#totalHT").html(number_format(totalHT,2,'.',''));
				$("#totalTVA").html(number_format(totalTVA,2,'.',''));
				$("#totalTTC").html(number_format(totalTTC,2,'.',''));
				$("#panier_1").css('display','');
				$("#panier_1").append('<tr id="trCat_1" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_1" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
				$("#panier_1").append('<tr id="trQuest_65"><td id="tdLabelQuest_65">'+text+'</td><td id="tdUniteQuest_65">m²</td><td id="tdQteQuest_65" class="n">'+number_format($("#quest_65").val(),2,'.','')+'</td><td id="tdPrixUniQuest_65" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_65" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
			}
			else
			{
				if ( $("#quest_65").val() )
				{
					prixAncienCat=$("#prixCateg_1").html(); 
					totalHTancien=$("#totalHT").html();
					prixUnitaire=50;
					text='Fourniture et pose d\'une dalle en béton';
					prixQuest=(prixUnitaire*$("#quest_65").val());
					if ( $("#trQuest_65").size()==0 )
					{
						prixCat=(prixAncienCat*1) + prixQuest;
						totalHT=(totalHTancien*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
						$("#panier_1").append('<tr id="trQuest_65"><td id="tdLabelQuest_65">'+text+'</td><td id="tdUniteQuest_65">m²</td><td id="tdQteQuest_65" class="n">'+number_format($("#quest_65").val(),2,'.','')+'</td><td id="tdPrixUniQuest_65" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_65" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
					}
					else
					{
						prixAncienQuest=$("#tdPrixQuest_65").html();
						prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
						totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
						$("#tdQteQuest_65").html(number_format($("#quest_65").val(),2,'.',''));
						$("#tdPrixQuest_65").html(number_format(prixQuest,2,'.',''));
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_1").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_65").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
					$("#trQuest_65").remove();
					if ( $("#panier_1").html()=='<tr id="trCat_1" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_1" class="n">0.00</th></tr>' ) 
						$("#trCat_1").remove();
				}
			}			
		}
		// Partie Maçonnerie --------------- Plancher --------------
		else if ( idQ==66 )
		{
			if ( $("#panier_1").html()=="" )
			{
				totalHTancien=$("#totalHT").html();
				prixUnitaire=105;
				text='Fourniture et pose d\'une dalle en béton';
				prixQuest=(prixUnitaire*$("#quest_66").val());
				prixCat=prixQuest;
				totalHT=(totalHTancien*1)+prixQuest;
				totalTVA=totalHT*19.6/100;
				totalTTC=totalHT+totalTVA;
				$("#totalHT").html(number_format(totalHT,2,'.',''));
				$("#totalTVA").html(number_format(totalTVA,2,'.',''));
				$("#totalTTC").html(number_format(totalTTC,2,'.',''));
				$("#panier_1").css('display','');
				$("#panier_1").append('<tr id="trCat_1" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_1" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
				$("#panier_1").append('<tr id="trQuest_66"><td id="tdLabelQuest_66">'+text+'</td><td id="tdUniteQuest_66">m²</td><td id="tdQteQuest_66" class="n">'+number_format($("#quest_66").val(),2,'.','')+'</td><td id="tdPrixUniQuest_66" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_66" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
			}
			else
			{
				if ( $("#quest_66").val() )
				{
					prixAncienCat=$("#prixCateg_1").html(); 
					totalHTancien=$("#totalHT").html();
					prixUnitaire=105;
					text='Fourniture et pose d\'une dalle en béton';
					prixQuest=(prixUnitaire*$("#quest_66").val());
					if ( $("#trQuest_66").size()==0 )
					{
						prixCat=(prixAncienCat*1) + prixQuest;
						totalHT=(totalHTancien*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
						$("#panier_1").append('<tr id="trQuest_66"><td id="tdLabelQuest_66">'+text+'</td><td id="tdUniteQuest_66">m²</td><td id="tdQteQuest_66" class="n">'+number_format($("#quest_66").val(),2,'.','')+'</td><td id="tdPrixUniQuest_66" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_66" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
					}
					else
					{
						prixAncienQuest=$("#tdPrixQuest_66").html();
						prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
						totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
						$("#tdQteQuest_66").html(number_format($("#quest_66").val(),2,'.',''));
						$("#tdPrixQuest_66").html(number_format(prixQuest,2,'.',''));
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_1").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_66").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
					$("#trQuest_66").remove();
					if ( $("#panier_1").html()=='<tr id="trCat_1" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_1" class="n">0.00</th></tr>' ) 
						$("#trCat_1").remove();
				}
			}			
		}
		// Partie Maçonnerie --------------- Terrassement --------------
		else if ( idQ==67 )
		{
			if ( $("#panier_1").html()=="" )
			{
				totalHTancien=$("#totalHT").html();
				prixUnitaire=13;
				text='Terrassement : creuser et déplacer de la terre';
				prixQuest=(prixUnitaire*$("#quest_67").val());
				prixCat=prixQuest;
				totalHT=(totalHTancien*1)+prixQuest;
				totalTVA=totalHT*19.6/100;
				totalTTC=totalHT+totalTVA;
				$("#totalHT").html(number_format(totalHT,2,'.',''));
				$("#totalTVA").html(number_format(totalTVA,2,'.',''));
				$("#totalTTC").html(number_format(totalTTC,2,'.',''));
				$("#panier_1").css('display','');
				$("#panier_1").append('<tr id="trCat_1" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_1" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
				$("#panier_1").append('<tr id="trQuest_67"><td id="tdLabelQuest_67">'+text+'</td><td id="tdUniteQuest_67">m3</td><td id="tdQteQuest_67" class="n">'+number_format($("#quest_67").val(),2,'.','')+'</td><td id="tdPrixUniQuest_67" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_67" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
			}
			else
			{
				if ( $("#quest_67").val() )
				{
					prixAncienCat=$("#prixCateg_1").html(); 
					totalHTancien=$("#totalHT").html();
					prixUnitaire=13;
					text='Terrassement : creuser et déplacer de la terre';
					prixQuest=(prixUnitaire*$("#quest_67").val());
					if ( $("#trQuest_67").size()==0 )
					{
						prixCat=(prixAncienCat*1) + prixQuest;
						totalHT=(totalHTancien*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
						$("#panier_1").append('<tr id="trQuest_67"><td id="tdLabelQuest_67">'+text+'</td><td id="tdUniteQuest_67">m3</td><td id="tdQteQuest_67" class="n">'+number_format($("#quest_67").val(),2,'.','')+'</td><td id="tdPrixUniQuest_67" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_67" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
					}
					else
					{
						prixAncienQuest=$("#tdPrixQuest_67").html();
						prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
						totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
						$("#tdQteQuest_67").html(number_format($("#quest_67").val(),2,'.',''));
						$("#tdPrixQuest_67").html(number_format(prixQuest,2,'.',''));
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_1").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_67").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_1").html(number_format(prixCat,2,'.',''));
					$("#trQuest_67").remove();
					if ( $("#panier_1").html()=='<tr id="trCat_1" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_1" class="n">0.00</th></tr>' ) 
						$("#trCat_1").remove();
				}
			}			
		}
		// Partie Plomberie --------------- Douche --------------
		else if ( idQ==37 )
		{
			if ( $("#panier_5").html()=="" )
			{
				totalHTancien=$("#totalHT").html();
				prixUnitaire_P1=200;
				prixUnitaire_P2=600;
				text_P1='Installation de cabine douche avec arrivée/évacuation d\'eau';
				text_P2='Fourniture de cabine de douche';
				prixQuest_P1=(prixUnitaire_P1*parseInt($("#quest_37").val()));
				prixQuest_P2=(prixUnitaire_P2*parseInt($("#quest_37").val()));
				prixCat=prixQuest_P1 + prixQuest_P2;
				totalHT=(totalHTancien*1) + prixQuest_P1 + prixQuest_P2;
				totalTVA=totalHT*19.6/100;
				totalTTC=totalHT+totalTVA;
				$("#totalHT").html(number_format(totalHT,2,'.',''));
				$("#totalTVA").html(number_format(totalTVA,2,'.',''));
				$("#totalTTC").html(number_format(totalTTC,2,'.',''));
				$("#panier_5").css('display','');
				$("#panier_5").append('<tr id="trCat_5" class="stot"><th colspan="3">Plomberie</th><th>sous-total HT</th><th id="prixCateg_5" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
				$("#panier_5").append('<tr id="trQuest_37_P1"><td id="tdLabelQuest_37_P1">'+text_P1+'</td><td id="tdUniteQuest_37_P1">unité</td><td id="tdQteQuest_37_P1" class="n">'+number_format(parseInt($("#quest_37").val()),2,'.','')+'</td><td id="tdPrixUniQuest_37_P1" class="n">'+number_format(prixUnitaire_P1,2,'.','')+'</td><td id="tdPrixQuest_37_P1" class="n">'+number_format(prixQuest_P1,2,'.','')+'</td></tr>');
				$("#panier_5").append('<tr id="trQuest_37_P2"><td id="tdLabelQuest_37_P2">'+text_P2+'</td><td id="tdUniteQuest_37_P2">unité</td><td id="tdQteQuest_37_P2" class="n">'+number_format(parseInt($("#quest_37").val()),2,'.','')+'</td><td id="tdPrixUniQuest_37_P2" class="n">'+number_format(prixUnitaire_P2,2,'.','')+'</td><td id="tdPrixQuest_37_P2" class="n">'+number_format(prixQuest_P2,2,'.','')+'</td></tr>');
			}
			else
			{
				if ( $("#quest_37").val() )
				{
					prixAncienCat=$("#prixCateg_5").html(); 
					totalHTancien=$("#totalHT").html();
					prixUnitaire_P1=200;
					prixUnitaire_P2=600;
					text_P1='Installation de cabine douche avec arrivée/évacuation d\'eau';
					text_P2='Fourniture de cabine de douche';
					prixQuest_P1=(prixUnitaire_P1*parseInt($("#quest_37").val()));
					prixQuest_P2=(prixUnitaire_P2*parseInt($("#quest_37").val()));
					if ( $("#trQuest_37_P1").size()==0 )
					{
						prixCat=(prixAncienCat*1) + prixQuest_P1 + prixQuest_P2;
						totalHT=(totalHTancien*1) + prixQuest_P1 + prixQuest_P2;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
						$("#panier_5").append('<tr id="trQuest_37_P1"><td id="tdLabelQuest_37_P1">'+text_P1+'</td><td id="tdUniteQuest_37_P1">unité</td><td id="tdQteQuest_37_P1" class="n">'+number_format(parseInt($("#quest_37").val()),2,'.','')+'</td><td id="tdPrixUniQuest_37_P1" class="n">'+number_format(prixUnitaire_P1,2,'.','')+'</td><td id="tdPrixQuest_37_P1" class="n">'+number_format(prixQuest_P1,2,'.','')+'</td></tr>');
						$("#panier_5").append('<tr id="trQuest_37_P2"><td id="tdLabelQuest_37_P2">'+text_P2+'</td><td id="tdUniteQuest_37_P2">unité</td><td id="tdQteQuest_37_P2" class="n">'+number_format(parseInt($("#quest_37").val()),2,'.','')+'</td><td id="tdPrixUniQuest_37_P2" class="n">'+number_format(prixUnitaire_P2,2,'.','')+'</td><td id="tdPrixQuest_37_P2" class="n">'+number_format(prixQuest_P2,2,'.','')+'</td></tr>');
					}
					else
					{
						prixAncienQuest_P1=$("#tdPrixQuest_37_P1").html();
						prixAncienQuest_P2=$("#tdPrixQuest_37_P2").html();
						prixCat=(prixAncienCat*1) - (prixAncienQuest_P1*1) - (prixAncienQuest_P2*1) + prixQuest_P1 + prixQuest_P2;
						totalHT=(totalHTancien*1) - (prixAncienQuest_P1*1) - (prixAncienQuest_P2*1) + prixQuest_P1 + prixQuest_P2;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
						$("#tdQteQuest_37_P1").html(number_format(parseInt($("#quest_37").val()),2,'.',''));
						$("#tdQteQuest_37_P2").html(number_format(parseInt($("#quest_37").val()),2,'.',''));
						$("#tdPrixQuest_37_P1").html(number_format(prixQuest_P1,2,'.',''));
						$("#tdPrixQuest_37_P2").html(number_format(prixQuest_P2,2,'.',''));
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_5").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest_P1=$("#tdPrixQuest_37_P1").html();
					prixAncienQuest_P2=$("#tdPrixQuest_37_P2").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest_P1*1) - (prixAncienQuest_P2*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest_P1*1) - (prixAncienQuest_P2*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
					$("#trQuest_37_P1").remove();
					$("#trQuest_37_P2").remove();
					if ( $("#panier_5").html()=='<tr id="trCat_5" class="stot"><th colspan="3">Plomberie</th><th>sous-total HT</th><th id="prixCateg_5" class="n">0.00</th></tr>' ) 
						$("#trCat_5").remove();
				}
			}
		}
		else if ( idQ==100 )
		{
			if ( $("#quest_100").val()==145 ) 
			{
				$("#suite_quest_100").css('display','');
			}
			else if ( $("#quest_100").val()==144 ) 
			{
				$("#suite_quest_100").css('display','none');
			}
			else 
			{
				$("#suite_quest_100").css('display','none');
			}
		}
		// Partie Plomberie --------------- Baignoire --------------
		else if ( idQ==38 )
		{
			if ( $("#panier_5").html()=="" )
			{
				totalHTancien=$("#totalHT").html();
				prixUnitaire_P1=200;
				prixUnitaire_P2=500;
				text_P1='Installation de baignoire en acier émaillé avec arrivée/évacuation d\'eau';
				text_P2='Fourniture de baignoire';
				prixQuest_P1=(prixUnitaire_P1*parseInt($("#quest_38").val()));
				prixQuest_P2=(prixUnitaire_P2*parseInt($("#quest_38").val()));
				prixCat=prixQuest_P1 + prixQuest_P2;
				totalHT=(totalHTancien*1) + prixQuest_P1 + prixQuest_P2;
				totalTVA=totalHT*19.6/100;
				totalTTC=totalHT+totalTVA;
				$("#totalHT").html(number_format(totalHT,2,'.',''));
				$("#totalTVA").html(number_format(totalTVA,2,'.',''));
				$("#totalTTC").html(number_format(totalTTC,2,'.',''));
				$("#panier_5").css('display','');
				$("#panier_5").append('<tr id="trCat_5" class="stot"><th colspan="3">Plomberie</th><th>sous-total HT</th><th id="prixCateg_5" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
				$("#panier_5").append('<tr id="trQuest_38_P1"><td id="tdLabelQuest_38_P1">'+text_P1+'</td><td id="tdUniteQuest_38_P1">unité</td><td id="tdQteQuest_38_P1" class="n">'+number_format(parseInt($("#quest_38").val()),2,'.','')+'</td><td id="tdPrixUniQuest_38_P1" class="n">'+number_format(prixUnitaire_P1,2,'.','')+'</td><td id="tdPrixQuest_38_P1" class="n">'+number_format(prixQuest_P1,2,'.','')+'</td></tr>');
				$("#panier_5").append('<tr id="trQuest_38_P2"><td id="tdLabelQuest_38_P2">'+text_P2+'</td><td id="tdUniteQuest_38_P2">unité</td><td id="tdQteQuest_38_P2" class="n">'+number_format(parseInt($("#quest_38").val()),2,'.','')+'</td><td id="tdPrixUniQuest_38_P2" class="n">'+number_format(prixUnitaire_P2,2,'.','')+'</td><td id="tdPrixQuest_38_P2" class="n">'+number_format(prixQuest_P2,2,'.','')+'</td></tr>');
			}
			else
			{
				if ( $("#quest_38").val() )
				{
					prixAncienCat=$("#prixCateg_5").html(); 
					totalHTancien=$("#totalHT").html();
					prixUnitaire_P1=200;
					prixUnitaire_P2=500;
					text_P1='Installation de baignoire en acier émaillé avec arrivée/évacuation d\'eau';
					text_P2='Fourniture de baignoire';
					prixQuest_P1=(prixUnitaire_P1*parseInt($("#quest_38").val()));
					prixQuest_P2=(prixUnitaire_P2*parseInt($("#quest_38").val()));
					if ( $("#trQuest_38_P1").size()==0 )
					{
						prixCat=(prixAncienCat*1) + prixQuest_P1 + prixQuest_P2;
						totalHT=(totalHTancien*1) + prixQuest_P1 + prixQuest_P2;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
						$("#panier_5").append('<tr id="trQuest_38_P1"><td id="tdLabelQuest_38_P1">'+text_P1+'</td><td id="tdUniteQuest_38_P1">unité</td><td id="tdQteQuest_38_P1" class="n">'+number_format(parseInt($("#quest_38").val()),2,'.','')+'</td><td id="tdPrixUniQuest_38_P1" class="n">'+number_format(prixUnitaire_P1,2,'.','')+'</td><td id="tdPrixQuest_38_P1" class="n">'+number_format(prixQuest_P1,2,'.','')+'</td></tr>');
						$("#panier_5").append('<tr id="trQuest_38_P2"><td id="tdLabelQuest_38_P2">'+text_P2+'</td><td id="tdUniteQuest_38_P2">unité</td><td id="tdQteQuest_38_P2" class="n">'+number_format(parseInt($("#quest_38").val()),2,'.','')+'</td><td id="tdPrixUniQuest_38_P2" class="n">'+number_format(prixUnitaire_P2,2,'.','')+'</td><td id="tdPrixQuest_38_P2" class="n">'+number_format(prixQuest_P2,2,'.','')+'</td></tr>');
					}
					else
					{
						prixAncienQuest_P1=$("#tdPrixQuest_38_P1").html();
						prixAncienQuest_P2=$("#tdPrixQuest_38_P2").html();
						prixCat=(prixAncienCat*1) - (prixAncienQuest_P1*1) - (prixAncienQuest_P2*1) + prixQuest_P1 + prixQuest_P2;
						totalHT=(totalHTancien*1) - (prixAncienQuest_P1*1) - (prixAncienQuest_P2*1) + prixQuest_P1 + prixQuest_P2;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
						$("#tdQteQuest_38_P1").html(number_format(parseInt($("#quest_38").val()),2,'.',''));
						$("#tdQteQuest_38_P2").html(number_format(parseInt($("#quest_38").val()),2,'.',''));
						$("#tdPrixQuest_38_P1").html(number_format(prixQuest_P1,2,'.',''));
						$("#tdPrixQuest_38_P2").html(number_format(prixQuest_P2,2,'.',''));
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_5").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest_P1=$("#tdPrixQuest_38_P1").html();
					prixAncienQuest_P2=$("#tdPrixQuest_38_P2").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest_P1*1) - (prixAncienQuest_P2*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest_P1*1) - (prixAncienQuest_P2*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
					$("#trQuest_38_P1").remove();
					$("#trQuest_38_P2").remove();
					if ( $("#panier_5").html()=='<tr id="trCat_5" class="stot"><th colspan="3">Plomberie</th><th>sous-total HT</th><th id="prixCateg_5" class="n">0.00</th></tr>' ) 
						$("#trCat_5").remove();
				}
			}
		}
		else if ( idQ==107 )
		{
			if ( $("#quest_107").val()==149 ) 
			{
				$("#suite_quest_107").css('display','');
			}
			else if ( $("#quest_107").val()==148 ) 
			{
				$("#suite_quest_107").css('display','none');
			}
			else 
			{
				$("#suite_quest_107").css('display','none');
			}
		}
		// Partie Plomberie --------------- Evier --------------
		else if ( idQ==39 )
		{
			if ( $("#panier_5").html()=="" )
			{
				totalHTancien=$("#totalHT").html();
				prixUnitaire_P1=175;
				prixUnitaire_P2=250;
				text_P1='Installation d\'évier avec arrivée/évacuation d\'eau';
				text_P2='Fourniture d\'évier';
				prixQuest_P1=(prixUnitaire_P1*parseInt($("#quest_39").val()));
				prixQuest_P2=(prixUnitaire_P2*parseInt($("#quest_39").val()));
				prixCat=prixQuest_P1 + prixQuest_P2;
				totalHT=(totalHTancien*1) + prixQuest_P1 + prixQuest_P2;
				totalTVA=totalHT*19.6/100;
				totalTTC=totalHT+totalTVA;
				$("#totalHT").html(number_format(totalHT,2,'.',''));
				$("#totalTVA").html(number_format(totalTVA,2,'.',''));
				$("#totalTTC").html(number_format(totalTTC,2,'.',''));
				$("#panier_5").css('display','');
				$("#panier_5").append('<tr id="trCat_5" class="stot"><th colspan="3">Plomberie</th><th>sous-total HT</th><th id="prixCateg_5" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
				$("#panier_5").append('<tr id="trQuest_39_P1"><td id="tdLabelQuest_39_P1">'+text_P1+'</td><td id="tdUniteQuest_39_P1">unité</td><td id="tdQteQuest_39_P1" class="n">'+number_format(parseInt($("#quest_39").val()),2,'.','')+'</td><td id="tdPrixUniQuest_39_P1" class="n">'+number_format(prixUnitaire_P1,2,'.','')+'</td><td id="tdPrixQuest_39_P1" class="n">'+number_format(prixQuest_P1,2,'.','')+'</td></tr>');
				$("#panier_5").append('<tr id="trQuest_39_P2"><td id="tdLabelQuest_39_P2">'+text_P2+'</td><td id="tdUniteQuest_39_P2">unité</td><td id="tdQteQuest_39_P2" class="n">'+number_format(parseInt($("#quest_39").val()),2,'.','')+'</td><td id="tdPrixUniQuest_39_P2" class="n">'+number_format(prixUnitaire_P2,2,'.','')+'</td><td id="tdPrixQuest_39_P2" class="n">'+number_format(prixQuest_P2,2,'.','')+'</td></tr>');
			}
			else
			{
				if ( $("#quest_39").val() )
				{
					prixAncienCat=$("#prixCateg_5").html(); 
					totalHTancien=$("#totalHT").html();
					prixUnitaire_P1=175;
					prixUnitaire_P2=250;
					text_P1='Installation d\'évier avec arrivée/évacuation d\'eau';
					text_P2='Fourniture d\'évier';
					prixQuest_P1=(prixUnitaire_P1*parseInt($("#quest_39").val()));
					prixQuest_P2=(prixUnitaire_P2*parseInt($("#quest_39").val()));
					if ( $("#trQuest_39_P1").size()==0 )
					{
						prixCat=(prixAncienCat*1) + prixQuest_P1 + prixQuest_P2;
						totalHT=(totalHTancien*1) + prixQuest_P1 + prixQuest_P2;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
						$("#panier_5").append('<tr id="trQuest_39_P1"><td id="tdLabelQuest_39_P1">'+text_P1+'</td><td id="tdUniteQuest_39_P1">unité</td><td id="tdQteQuest_39_P1" class="n">'+number_format(parseInt($("#quest_39").val()),2,'.','')+'</td><td id="tdPrixUniQuest_39_P1" class="n">'+number_format(prixUnitaire_P1,2,'.','')+'</td><td id="tdPrixQuest_39_P1" class="n">'+number_format(prixQuest_P1,2,'.','')+'</td></tr>');
						$("#panier_5").append('<tr id="trQuest_39_P2"><td id="tdLabelQuest_39_P2">'+text_P2+'</td><td id="tdUniteQuest_39_P2">unité</td><td id="tdQteQuest_39_P2" class="n">'+number_format(parseInt($("#quest_39").val()),2,'.','')+'</td><td id="tdPrixUniQuest_39_P2" class="n">'+number_format(prixUnitaire_P2,2,'.','')+'</td><td id="tdPrixQuest_39_P2" class="n">'+number_format(prixQuest_P2,2,'.','')+'</td></tr>');
					}
					else
					{
						prixAncienQuest_P1=$("#tdPrixQuest_39_P1").html();
						prixAncienQuest_P2=$("#tdPrixQuest_39_P2").html();
						prixCat=(prixAncienCat*1) - (prixAncienQuest_P1*1) - (prixAncienQuest_P2*1) + prixQuest_P1 + prixQuest_P2;
						totalHT=(totalHTancien*1) - (prixAncienQuest_P1*1) - (prixAncienQuest_P2*1) + prixQuest_P1 + prixQuest_P2;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
						$("#tdQteQuest_39_P1").html(number_format(parseInt($("#quest_39").val()),2,'.',''));
						$("#tdQteQuest_39_P2").html(number_format(parseInt($("#quest_39").val()),2,'.',''));
						$("#tdPrixQuest_39_P1").html(number_format(prixQuest_P1,2,'.',''));
						$("#tdPrixQuest_39_P2").html(number_format(prixQuest_P2,2,'.',''));
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_5").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest_P1=$("#tdPrixQuest_39_P1").html();
					prixAncienQuest_P2=$("#tdPrixQuest_39_P2").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest_P1*1) - (prixAncienQuest_P2*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest_P1*1) - (prixAncienQuest_P2*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
					$("#trQuest_39_P1").remove();
					$("#trQuest_39_P2").remove();
					if ( $("#panier_5").html()=='<tr id="trCat_5" class="stot"><th colspan="3">Plomberie</th><th>sous-total HT</th><th id="prixCateg_5" class="n">0.00</th></tr>' ) 
						$("#trCat_5").remove();
				}
			}
		}
		else if ( idQ==113 )
		{
			if ( $("#quest_113").val()==153 ) 
			{
				$("#suite_quest_113").css('display','');
			}
			else if ( $("#quest_113").val()==152 ) 
			{
				$("#suite_quest_113").css('display','none');
			}
			else 
			{
				$("#suite_quest_113").css('display','none');
			}
		}
		// Partie Plomberie --------------- WC --------------
		else if ( idQ==40 )
		{
			if ( $("#panier_5").html()=="" )
			{
				totalHTancien=$("#totalHT").html();
				prixUnitaire=300;
				text='Fourniture et installation de WC';
				prixQuest=(prixUnitaire*parseInt($("#quest_40").val()));
				prixCat=prixQuest;
				totalHT=(totalHTancien*1)+prixQuest;
				totalTVA=totalHT*19.6/100;
				totalTTC=totalHT+totalTVA;
				$("#totalHT").html(number_format(totalHT,2,'.',''));
				$("#totalTVA").html(number_format(totalTVA,2,'.',''));
				$("#totalTTC").html(number_format(totalTTC,2,'.',''));
				$("#panier_5").css('display','');
				$("#panier_5").append('<tr id="trCat_5" class="stot"><th colspan="3">Plomberie</th><th>sous-total HT</th><th id="prixCateg_5" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
				$("#panier_5").append('<tr id="trQuest_40"><td id="tdLabelQuest_40">'+text+'</td><td id="tdUniteQuest_40">unité</td><td id="tdQteQuest_40" class="n">'+number_format(parseInt($("#quest_40").val()),2,'.','')+'</td><td id="tdPrixUniQuest_40" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_40" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
			}
			else
			{
				if ( $("#quest_40").val() )
				{
					prixAncienCat=$("#prixCateg_5").html(); 
					totalHTancien=$("#totalHT").html();
					prixUnitaire=300;
					text='Fourniture et installation de WC';
					prixQuest=prixUnitaire*parseInt($("#quest_40").val());
					if ( $("#trQuest_40").size()==0 )
					{
						prixCat=(prixAncienCat*1) + prixQuest;
						totalHT=(totalHTancien*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
						$("#panier_5").append('<tr id="trQuest_40"><td id="tdLabelQuest_40">'+text+'</td><td id="tdUniteQuest_40">unité</td><td id="tdQteQuest_40" class="n">'+number_format(parseInt($("#quest_40").val()),2,'.','')+'</td><td id="tdPrixUniQuest_40" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_40" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
					}
					else
					{
						prixAncienQuest=$("#tdPrixQuest_40").html();
						prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
						totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
						$("#tdQteQuest_40").html(number_format(parseInt($("#quest_40").val()),2,'.',''));
						$("#tdPrixQuest_40").html(number_format(prixQuest,2,'.',''));
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_5").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_40").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
					$("#trQuest_40").remove();
					if ( $("#panier_5").html()=='<tr id="trCat_5" class="stot"><th colspan="3">Plomberie</th><th>sous-total HT</th><th id="prixCateg_5" class="n">0.00</th></tr>' ) 
						$("#trCat_5").remove();
				}
			}
		}
		else if ( idQ==119 )
		{
			if ( $("#quest_119").val()==157 ) 
			{
				$("#suite_quest_119").css('display','');
			}
			else if ( $("#quest_119").val()==156 ) 
			{
				$("#suite_quest_119").css('display','none');
			}
			else 
			{
				$("#suite_quest_119").css('display','none');
			}
		}
		// Partie Plomberie --------------- Chauffage --------------
		/*else if ( idQ==41 )
		{
			if ( $("#panier_5").html()=="" )
			{
				totalHTancien=$("#totalHT").html();
				prixUnitaire_P1=39;
				prixUnitaire_P2=39;
				prixUnitaire_P3=23;
				text_P1='Fourniture et installation de tuyaux de cuivre pour le circuit eau froide';
				text_P2='Fourniture et installation de tuyaux de cuivre pour le circuit eau chaude';
				text_P3='Fourniture et installation de tuyaux de pvc pour le circuit d\'évacuation d\'eau';
				prixQuest_P1=(prixUnitaire_P1*parseInt($("#quest_41").val()));
				prixQuest_P2=(prixUnitaire_P2*parseInt($("#quest_41").val()));
				prixQuest_P3=(prixUnitaire_P3*parseInt($("#quest_41").val()));
				prixCat=prixQuest_P1 + prixQuest_P2 + prixQuest_P3;
				totalHT=(totalHTancien*1) + prixQuest_P1 + prixQuest_P2 + prixQuest_P3;
				totalTVA=totalHT*19.6/100;
				totalTTC=totalHT+totalTVA;
				$("#totalHT").html(number_format(totalHT,2,'.',''));
				$("#totalTVA").html(number_format(totalTVA,2,'.',''));
				$("#totalTTC").html(number_format(totalTTC,2,'.',''));
				$("#panier_5").css('display','');
				$("#panier_5").append('<tr id="trCat_5" class="stot"><th colspan="3">Plomberie</th><th>sous-total HT</th><th id="prixCateg_5" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
				$("#panier_5").append('<tr id="trQuest_41_P1"><td id="tdLabelQuest_41_P1">'+text_P1+'</td><td id="tdUniteQuest_41_P1">m</td><td id="tdQteQuest_41_P1" class="n">'+number_format(parseInt($("#quest_41").val()),2,'.','')+'</td><td id="tdPrixUniQuest_41_P1" class="n">'+number_format(prixUnitaire_P1,2,'.','')+'</td><td id="tdPrixQuest_41_P1" class="n">'+number_format(prixQuest_P1,2,'.','')+'</td></tr>');
				$("#panier_5").append('<tr id="trQuest_41_P2"><td id="tdLabelQuest_41_P2">'+text_P2+'</td><td id="tdUniteQuest_41_P2">m</td><td id="tdQteQuest_41_P2" class="n">'+number_format(parseInt($("#quest_41").val()),2,'.','')+'</td><td id="tdPrixUniQuest_41_P2" class="n">'+number_format(prixUnitaire_P2,2,'.','')+'</td><td id="tdPrixQuest_41_P2" class="n">'+number_format(prixQuest_P2,2,'.','')+'</td></tr>');
				$("#panier_5").append('<tr id="trQuest_41_P3"><td id="tdLabelQuest_41_P3">'+text_P3+'</td><td id="tdUniteQuest_41_P3">m</td><td id="tdQteQuest_41_P3" class="n">'+number_format(parseInt($("#quest_41").val()),2,'.','')+'</td><td id="tdPrixUniQuest_41_P3" class="n">'+number_format(prixUnitaire_P3,2,'.','')+'</td><td id="tdPrixQuest_41_P3" class="n">'+number_format(prixQuest_P3,2,'.','')+'</td></tr>');
			}
			else
			{
				if ( $("#quest_41").val() )
				{
					prixAncienCat=$("#prixCateg_5").html(); 
					totalHTancien=$("#totalHT").html();
					prixUnitaire_P1=39;
					prixUnitaire_P2=39;
					prixUnitaire_P3=23;
					text_P1='Fourniture et installation de tuyaux de cuivre pour le circuit eau froide';
					text_P2='Fourniture et installation de tuyaux de cuivre pour le circuit eau chaude';
					text_P3='Fourniture et installation de tuyaux de pvc pour le circuit d\'évacuation d\'eau';
					prixQuest_P1=(prixUnitaire_P1*parseInt($("#quest_41").val()));
					prixQuest_P2=(prixUnitaire_P2*parseInt($("#quest_41").val()));
					prixQuest_P3=(prixUnitaire_P3*parseInt($("#quest_41").val()));
					if ( $("#trQuest_41_P1").size()==0 )
					{
						prixCat=(prixAncienCat*1) + prixQuest_P1 + prixQuest_P2 + prixQuest_P3;
						totalHT=(totalHTancien*1) + prixQuest_P1 + prixQuest_P2 + prixQuest_P3;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
						$("#panier_5").append('<tr id="trQuest_41_P1"><td id="tdLabelQuest_41_P1">'+text_P1+'</td><td id="tdUniteQuest_41_P1">m</td><td id="tdQteQuest_41_P1" class="n">'+number_format(parseInt($("#quest_41").val()),2,'.','')+'</td><td id="tdPrixUniQuest_41_P1" class="n">'+number_format(prixUnitaire_P1,2,'.','')+'</td><td id="tdPrixQuest_41_P1" class="n">'+number_format(prixQuest_P1,2,'.','')+'</td></tr>');
						$("#panier_5").append('<tr id="trQuest_41_P2"><td id="tdLabelQuest_41_P2">'+text_P2+'</td><td id="tdUniteQuest_41_P2">m</td><td id="tdQteQuest_41_P2" class="n">'+number_format(parseInt($("#quest_41").val()),2,'.','')+'</td><td id="tdPrixUniQuest_41_P2" class="n">'+number_format(prixUnitaire_P2,2,'.','')+'</td><td id="tdPrixQuest_41_P2" class="n">'+number_format(prixQuest_P2,2,'.','')+'</td></tr>');
						$("#panier_5").append('<tr id="trQuest_41_P3"><td id="tdLabelQuest_41_P3">'+text_P2+'</td><td id="tdUniteQuest_41_P3">m</td><td id="tdQteQuest_41_P3" class="n">'+number_format(parseInt($("#quest_41").val()),2,'.','')+'</td><td id="tdPrixUniQuest_41_P3" class="n">'+number_format(prixUnitaire_P3,2,'.','')+'</td><td id="tdPrixQuest_41_P3" class="n">'+number_format(prixQuest_P3,2,'.','')+'</td></tr>');
					}
					else
					{
						prixAncienQuest_P1=$("#tdPrixQuest_41_P1").html();
						prixAncienQuest_P2=$("#tdPrixQuest_41_P2").html();
						prixAncienQuest_P3=$("#tdPrixQuest_41_P3").html();
						prixCat=(prixAncienCat*1) - (prixAncienQuest_P1*1) - (prixAncienQuest_P2*1) - (prixAncienQuest_P3*1) + prixQuest_P1 + prixQuest_P2 + prixQuest_P3;
						totalHT=(totalHTancien*1) - (prixAncienQuest_P1*1) - (prixAncienQuest_P2*1) - (prixAncienQuest_P3*1) + prixQuest_P1 + prixQuest_P2 + prixQuest_P3;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
						$("#tdQteQuest_41_P1").html(number_format(parseInt($("#quest_41").val()),2,'.',''));
						$("#tdQteQuest_41_P2").html(number_format(parseInt($("#quest_41").val()),2,'.',''));
						$("#tdQteQuest_41_P3").html(number_format(parseInt($("#quest_41").val()),2,'.',''));
						$("#tdPrixQuest_41_P1").html(number_format(prixQuest_P1,2,'.',''));
						$("#tdPrixQuest_41_P2").html(number_format(prixQuest_P2,2,'.',''));
						$("#tdPrixQuest_41_P3").html(number_format(prixQuest_P3,2,'.',''));
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_5").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest_P1=$("#tdPrixQuest_41_P1").html();
					prixAncienQuest_P2=$("#tdPrixQuest_41_P2").html();
					prixAncienQuest_P3=$("#tdPrixQuest_41_P3").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest_P1*1) - (prixAncienQuest_P2*1) - (prixAncienQuest_P3*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest_P1*1) - (prixAncienQuest_P2*1) - (prixAncienQuest_P3*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
					$("#trQuest_41_P1").remove();
					$("#trQuest_41_P2").remove();
					$("#trQuest_41_P3").remove();
					if ( $("#panier_5").html()=='<tr id="trCat_5" class="stot"><th colspan="3">Plomberie</th><th>sous-total HT</th><th id="prixCateg_5" class="n">0.00</th></tr>' ) 
						$("#trCat_5").remove();
				}
			}
		}
		else if ( idQ==42 )
		{
			if ( $("#panier_5").html()=="" )
			{
				totalHTancien=$("#totalHT").html();
				prixUnitaire=150;
				text='Nombre d\'arrivées/évacuations d\'eau';
				prixQuest=(prixUnitaire*parseInt($("#quest_42").val()));
				prixCat=prixQuest;
				totalHT=(totalHTancien*1)+prixQuest;
				totalTVA=totalHT*19.6/100;
				totalTTC=totalHT+totalTVA;
				$("#totalHT").html(number_format(totalHT,2,'.',''));
				$("#totalTVA").html(number_format(totalTVA,2,'.',''));
				$("#totalTTC").html(number_format(totalTTC,2,'.',''));
				$("#panier_5").css('display','');
				$("#panier_5").append('<tr id="trCat_5" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_5" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
				$("#panier_5").append('<tr id="trQuest_42"><td id="tdLabelQuest_42">'+text+'</td><td id="tdUniteQuest_42">unité</td><td id="tdQteQuest_42" class="n">'+number_format(parseInt($("#quest_42").val()),2,'.','')+'</td><td id="tdPrixUniQuest_42" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_42" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
			}
			else
			{
				if ( $("#quest_42").val() )
				{
					prixAncienCat=$("#prixCateg_5").html(); 
					totalHTancien=$("#totalHT").html();
					prixUnitaire=150;
					text='Nombre d\'arrivées/évacuations d\'eau';
					prixQuest=prixUnitaire*parseInt($("#quest_42").val());
					if ( $("#trQuest_42").size()==0 )
					{
						prixCat=(prixAncienCat*1) + prixQuest;
						totalHT=(totalHTancien*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
						$("#panier_5").append('<tr id="trQuest_42"><td id="tdLabelQuest_42">'+text+'</td><td id="tdUniteQuest_42">unité</td><td id="tdQteQuest_42" class="n">'+number_format(parseInt($("#quest_42").val()),2,'.','')+'</td><td id="tdPrixUniQuest_42" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_42" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
					}
					else
					{
						prixAncienQuest=$("#tdPrixQuest_42").html();
						prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
						totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
						$("#tdQteQuest_42").html(number_format(parseInt($("#quest_42").val()),2,'.',''));
						$("#tdPrixQuest_42").html(number_format(prixQuest,2,'.',''));
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_5").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_42").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
					$("#trQuest_42").remove();
					if ( $("#panier_5").html()=='<tr id="trCat_5" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_5" class="n">0.00</th></tr>' ) 
						$("#trCat_5").remove();
				}
			}
		}*/
		else if ( idQ==130 )
		{
			if ( $("#quest_130").val()==177 || $("#quest_130").val()==178 || $("#quest_130").val()==179 ) 
			{
				$("#suite_quest_131").css('display','');
			}
			else if ( $("#quest_130").val()==180 ) 
			{
				$("#suite_quest_131").css('display','none');
			}
			else 
			{
				$("#suite_quest_131").css('display','none');
			}
		}
		// Partie Plomberie --------------- Autre --------------
		/*else if ( idQ==44 )
		{
			if ( $("#panier_5").html()=="" )
			{
				totalHTancien=$("#totalHT").html();
				prixUnitaire=500;
				text='Fourniture et installation de ballon d\'eau chaude';
				prixQuest=(prixUnitaire*parseInt($("#quest_44").val()));
				prixCat=prixQuest;
				totalHT=(totalHTancien*1)+prixQuest;
				totalTVA=totalHT*19.6/100;
				totalTTC=totalHT+totalTVA;
				$("#totalHT").html(number_format(totalHT,2,'.',''));
				$("#totalTVA").html(number_format(totalTVA,2,'.',''));
				$("#totalTTC").html(number_format(totalTTC,2,'.',''));
				$("#panier_5").css('display','');
				$("#panier_5").append('<tr id="trCat_5" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_5" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
				$("#panier_5").append('<tr id="trQuest_44"><td id="tdLabelQuest_44">'+text+'</td><td id="tdUniteQuest_44">unité</td><td id="tdQteQuest_44" class="n">'+number_format(parseInt($("#quest_44").val()),2,'.','')+'</td><td id="tdPrixUniQuest_44" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_44" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
			}
			else
			{
				if ( $("#quest_44").val() )
				{
					prixAncienCat=$("#prixCateg_5").html(); 
					totalHTancien=$("#totalHT").html();
					prixUnitaire=500;
					text='Fourniture et installation de ballon d\'eau chaude';
					prixQuest=prixUnitaire*parseInt($("#quest_44").val());
					if ( $("#trQuest_44").size()==0 )
					{
						prixCat=(prixAncienCat*1) + prixQuest;
						totalHT=(totalHTancien*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
						$("#panier_5").append('<tr id="trQuest_44"><td id="tdLabelQuest_44">'+text+'</td><td id="tdUniteQuest_44">unité</td><td id="tdQteQuest_44" class="n">'+number_format(parseInt($("#quest_44").val()),2,'.','')+'</td><td id="tdPrixUniQuest_44" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_44" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
					}
					else
					{
						prixAncienQuest=$("#tdPrixQuest_44").html();
						prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
						totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
						$("#tdQteQuest_44").html(number_format(parseInt($("#quest_44").val()),2,'.',''));
						$("#tdPrixQuest_44").html(number_format(prixQuest,2,'.',''));
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_5").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_44").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_5").html(number_format(prixCat,2,'.',''));
					$("#trQuest_44").remove();
					if ( $("#panier_5").html()=='<tr id="trCat_5" class="stot"><th colspan="3">Maçonnerie</th><th>sous-total HT</th><th id="prixCateg_5" class="n">0.00</th></tr>' ) 
						$("#trCat_5").remove();
				}
			}
		}*/
		else if ( idQ==133 )
		{
			if ( $("#quest_133").val()==186 ) 
			{
				$("#suite_quest_133").css('display','');
			}
			else if ( $("#quest_133").val()==185 ) 
			{
				$("#suite_quest_133").css('display','none');
			}
			else 
			{
				$("#suite_quest_133").css('display','none');
			}
		}
		else if ( idQ==136 )
		{
			if ( $("#quest_136").val()==187 || $("#quest_136").val()==188 ) 
			{
				$("#suite_quest_136_1").css('display','');
				$("#suite_quest_136_2").css('display','none');
				$("#suite_quest_136_3").css('display','none');
			}
			else if ( $("#quest_136").val()==189 || $("#quest_136").val()==190 ) 
			{
				$("#suite_quest_136_1").css('display','none');
				$("#suite_quest_136_2").css('display','');
				$("#suite_quest_136_3").css('display','none');
			}
			else if ( $("#quest_136").val()==191 ) 
			{
				$("#suite_quest_136_1").css('display','none');
				$("#suite_quest_136_2").css('display','none');
				$("#suite_quest_136_3").css('display','');
			}
			else 
			{
				$("#suite_quest_136_1").css('display','none');
				$("#suite_quest_136_2").css('display','none');
				$("#suite_quest_136_3").css('display','none');
			}
		}
		
		
		
		// Partie Electricité --------------- Généralités --------------
		/*else if ( idQ==33 ) 
		{  
			if ( $("#quest_33").val()==0 )
			{
				if ( $("#quest_36").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_33_36").html();
					prixAncienCat=$("#prixCateg_6").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_33_36").html('Donner plus de précisions, en répondant aux questions pour la partie : Généralités');
					$("#tdUniteQuest_33_36").html('');
					$("#tdQteQuest_33_36").html('0.00');
					$("#tdPrixUniQuest_33_36").html('0.00');
					$("#tdPrixQuest_33_36").html('0.00');
				}
				if ( $("#quest_34").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_33_34").html();
					prixAncienCat=$("#prixCateg_6").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_33_34").html('Donner plus de précisions, en répondant aux questions pour la partie : Généralités');
					$("#tdUniteQuest_33_34").html('');
					$("#tdQteQuest_33_34").html('0.00');
					$("#tdPrixUniQuest_33_34").html('0.00');
					$("#tdPrixQuest_33_34").html('0.00');
				}
			}
			else
			{
				if ( $("#quest_36").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_6").html(); 
					prixAncienQuest=$("#tdPrixQuest_33_36").html();
					if ( $("#quest_33").val()==48 ) { prixUnitaire=83;prixQuest=(prixUnitaire*parseInt($("#quest_36").val()));text='Prises électriques, pose avant doublage'; }
					else if ( $("#quest_33").val()==49 ) { prixUnitaire=128;prixQuest=(prixUnitaire*parseInt($("#quest_36").val()));text='Prises électriques, pose encastrée'; }
					else if ( $("#quest_33").val()==50 ) { prixUnitaire=98;prixQuest=(prixUnitaire*parseInt($("#quest_36").val()));text='Prises électriques, pose sous goulotte'; }
					else if ( $("#quest_33").val()==51 ) { prixUnitaire=113;prixQuest=(prixUnitaire*parseInt($("#quest_36").val()));text='Prises électriques, pose semi encastrée'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_33_36").html(text);
					$("#tdUniteQuest_33_36").html('unité');
					$("#tdQteQuest_33_36").html(number_format(parseInt($("#quest_36").val()),2,'.',''));
					$("#tdPrixUniQuest_33_36").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_33_36").html(number_format(prixQuest,2,'.',''));
				}
				if ( $("#quest_34").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_6").html(); 
					prixAncienQuest=$("#tdPrixQuest_33_34").html();
					if ( $("#quest_33").val()==48 ) { prixUnitaire=101;prixQuest=(prixUnitaire*parseInt($("#quest_34").val()));text='Prises électriques, pose avant doublage'; }
					else if ( $("#quest_33").val()==49 ) { prixUnitaire=156;prixQuest=(prixUnitaire*parseInt($("#quest_34").val()));text='Prises électriques, pose encastrée'; }
					else if ( $("#quest_33").val()==50 ) { prixUnitaire=119;prixQuest=(prixUnitaire*parseInt($("#quest_34").val()));text='Prises électriques, pose sous goulotte'; }
					else if ( $("#quest_33").val()==51 ) { prixUnitaire=138;prixQuest=(prixUnitaire*parseInt($("#quest_34").val()));text='Prises électriques, pose semi encastrée'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_33_34").html(text);
					$("#tdUniteQuest_33_34").html('unité');
					$("#tdQteQuest_33_34").html(number_format(parseInt($("#quest_34").val()),2,'.',''));
					$("#tdPrixUniQuest_33_34").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_33_34").html(number_format(prixQuest,2,'.',''));
				}
			}
		}*/
		// Partie Electricité --------------- Prises --------------
		else if ( idQ==33 ) 
		{  
			if ( $("#quest_33").val()==0 )
			{
				if ( $("#quest_36").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_33_36").html();
					prixAncienCat=$("#prixCateg_6").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_33_36").html('Donner plus de précisions, en répondant aux questions pour la partie : Prises');
					$("#tdUniteQuest_33_36").html('');
					$("#tdQteQuest_33_36").html('0.00');
					$("#tdPrixUniQuest_33_36").html('0.00');
					$("#tdPrixQuest_33_36").html('0.00');
				}
			}
			else
			{
				if ( $("#quest_36").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_6").html(); 
					prixAncienQuest=$("#tdPrixQuest_33_36").html();
					if ( $("#quest_33").val()==48 ) { prixUnitaire=83;prixQuest=(prixUnitaire*parseInt($("#quest_36").val()));text='Prises électriques, pose avant doublage'; }
					else if ( $("#quest_33").val()==49 ) { prixUnitaire=128;prixQuest=(prixUnitaire*parseInt($("#quest_36").val()));text='Prises électriques, pose encastrée'; }
					else if ( $("#quest_33").val()==50 ) { prixUnitaire=98;prixQuest=(prixUnitaire*parseInt($("#quest_36").val()));text='Prises électriques, pose sous goulotte'; }
					else if ( $("#quest_33").val()==51 ) { prixUnitaire=113;prixQuest=(prixUnitaire*parseInt($("#quest_36").val()));text='Prises électriques, pose semi encastrée'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_33_36").html(text);
					$("#tdUniteQuest_33_36").html('unité');
					$("#tdQteQuest_33_36").html(number_format(parseInt($("#quest_36").val()),2,'.',''));
					$("#tdPrixUniQuest_33_36").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_33_36").html(number_format(prixQuest,2,'.',''));
				}
			}
		}
		else if ( idQ==36 )
		{
			if ( $("#panier_6").html()=="" )
			{
				if ( $("#quest_36").val() )
				{
					if ( $("#quest_33").val()==0 )
					{
						$("#panier_6").css('display','');
						$("#panier_6").append('<tr id="trCat_6" class="stot"><th colspan="3">Electricité</th><th>sous-total HT</th><th id="prixCateg_6" class="n">0</th></tr>');
						$("#panier_6").append('<tr id="trQuest_33_36"><td id="tdLabelQuest_33_36">Donner plus de précisions, en répondant aux questions pour la partie : Prises</td><td id="tdUniteQuest_33_36"></td><td id="tdQteQuest_33_36" class="n">0.00</td><td id="tdPrixUniQuest_33_36" class="n">0.00</td><td id="tdPrixQuest_33_36" class="n">0.00</td></tr>');
					}
					else
					{
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_33").val()==48 ) { prixUnitaire=83;prixQuest=(prixUnitaire*parseInt($("#quest_36").val()));text='Prises électriques, pose avant doublage'; }
						else if ( $("#quest_33").val()==49 ) { prixUnitaire=128;prixQuest=(prixUnitaire*parseInt($("#quest_36").val()));text='Prises électriques, pose encastrée'; }
						else if ( $("#quest_33").val()==50 ) { prixUnitaire=98;prixQuest=(prixUnitaire*parseInt($("#quest_36").val()));text='Prises électriques, pose sous goulotte'; }
						else if ( $("#quest_33").val()==51 ) { prixUnitaire=113;prixQuest=(prixUnitaire*parseInt($("#quest_36").val()));text='Prises électriques, pose semi encastrée'; }
						prixCat=prixQuest;
						totalHT=(totalHTancien*1)+prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#panier_6").css('display','');
						$("#panier_6").append('<tr id="trCat_6" class="stot"><th colspan="3">Electricité</th><th>sous-total HT</th><th id="prixCateg_6" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
						$("#panier_6").append('<tr id="trQuest_33_36"><td id="tdLabelQuest_33_36">'+text+'</td><td id="tdUniteQuest_33_36">unité</td><td id="tdQteQuest_33_36" class="n">'+number_format(parseInt($("#quest_36").val()),2,'.','')+'</td><td id="tdPrixUniQuest_33_36" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_33_36" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
					}
				}
			}
			else
			{
				if ( $("#quest_36").val() )
				{
					if ( $("#quest_33").val()!=0 )
					{
						prixAncienCat=$("#prixCateg_6").html(); 
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_33").val()==48 ) { prixUnitaire=83;prixQuest=(prixUnitaire*parseInt($("#quest_36").val()));text='Prises électriques, pose avant doublage'; }
						else if ( $("#quest_33").val()==49 ) { prixUnitaire=128;prixQuest=(prixUnitaire*parseInt($("#quest_36").val()));text='Prises électriques, pose encastrée'; }
						else if ( $("#quest_33").val()==50 ) { prixUnitaire=98;prixQuest=(prixUnitaire*parseInt($("#quest_36").val()));text='Prises électriques, pose sous goulotte'; }
						else if ( $("#quest_33").val()==51 ) { prixUnitaire=113;prixQuest=(prixUnitaire*parseInt($("#quest_36").val()));text='Prises électriques, pose semi encastrée'; }
						if ( $("#trQuest_33_36").size()==0 )
						{
							prixCat=(prixAncienCat*1) + prixQuest;
							totalHT=(totalHTancien*1) + prixQuest;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
							$("#panier_6").append('<tr id="trQuest_33_36"><td id="tdLabelQuest_33_36">'+text+'</td><td id="tdUniteQuest_33_36">unité</td><td id="tdQteQuest_33_36" class="n">'+number_format(parseInt($("#quest_36").val()),2,'.','')+'</td><td id="tdPrixUniQuest_33_36" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_33_36" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
						}
						else
						{
							prixAncienQuest=$("#tdPrixQuest_33_36").html();
							prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
							totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
							$("#tdQteQuest_33_36").html(number_format(parseInt($("#quest_36").val()),2,'.',''));
							$("#tdPrixQuest_33_36").html(number_format(prixQuest,2,'.',''));
						}
					}
					else
					{
						if ( $("#trQuest_33_36").size()==0 )
						{
							$("#panier_6").append('<tr id="trQuest_33_36"><td id="tdLabelQuest_33_36">Donner plus de précisions, en répondant aux questions pour la partie : Prises</td><td id="tdUniteQuest_33_36"></td><td id="tdQteQuest_33_36" class="n">0.00</td><td id="tdPrixUniQuest_33_36" class="n">0.00</td><td id="tdPrixQuest_33_36" class="n">0.00</td></tr>');
						}
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_6").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_33_36").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
					$("#trQuest_33_36").remove();
					if ( $("#panier_6").html()=='<tr id="trCat_6" class="stot"><th colspan="3">Electricité</th><th>sous-total HT</th><th id="prixCateg_6" class="n">0.00</th></tr>' ) 
						$("#trCat_6").remove();
				}
			}
		}
		//Partie Electricité --------------- Eclairage --------------
		else if ( idQ==95 ) 
		{  
			if ( $("#quest_95").val()==0 )
			{
				if ( $("#quest_34").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_95_34").html();
					prixAncienCat=$("#prixCateg_6").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_95_34").html('Donner plus de précisions, en répondant aux questions pour la partie : Eclairage');
					$("#tdUniteQuest_95_34").html('');
					$("#tdQteQuest_95_34").html('0.00');
					$("#tdPrixUniQuest_95_34").html('0.00');
					$("#tdPrixQuest_95_34").html('0.00');
				}
			}
			else
			{
				if ( $("#quest_34").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_6").html(); 
					prixAncienQuest=$("#tdPrixQuest_95_34").html();
					if ( $("#quest_95").val()==138 ) { prixUnitaire=101;prixQuest=(prixUnitaire*parseInt($("#quest_34").val()));text='Prises électriques, pose avant doublage'; }
					else if ( $("#quest_95").val()==139 ) { prixUnitaire=156;prixQuest=(prixUnitaire*parseInt($("#quest_34").val()));text='Prises électriques, pose encastrée'; }
					else if ( $("#quest_95").val()==140 ) { prixUnitaire=119;prixQuest=(prixUnitaire*parseInt($("#quest_34").val()));text='Prises électriques, pose sous goulotte'; }
					else if ( $("#quest_95").val()==141 ) { prixUnitaire=138;prixQuest=(prixUnitaire*parseInt($("#quest_34").val()));text='Prises électriques, pose semi encastrée'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_95_34").html(text);
					$("#tdUniteQuest_95_34").html('unité');
					$("#tdQteQuest_95_34").html(number_format(parseInt($("#quest_34").val()),2,'.',''));
					$("#tdPrixUniQuest_95_34").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_95_34").html(number_format(prixQuest,2,'.',''));
				}
			}
		}		
		else if ( idQ==34 )
		{
			if ( $("#panier_6").html()=="" )
			{
				if ( $("#quest_34").val() )
				{
					if ( $("#quest_95").val()==0 )
					{
						$("#panier_6").css('display','');
						$("#panier_6").append('<tr id="trCat_6" class="stot"><th colspan="3">Electricité</th><th>sous-total HT</th><th id="prixCateg_6" class="n">0</th></tr>');
						$("#panier_6").append('<tr id="trQuest_95_34"><td id="tdLabelQuest_95_34">Donner plus de précisions, en répondant aux questions pour la partie : Eclairage</td><td id="tdUniteQuest_95_34"></td><td id="tdQteQuest_95_34" class="n">0.00</td><td id="tdPrixUniQuest_95_34" class="n">0.00</td><td id="tdPrixQuest_95_34" class="n">0.00</td></tr>');
					}
					else
					{
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_95").val()==138 ) { prixUnitaire=101;prixQuest=(prixUnitaire*parseInt($("#quest_34").val()));text='Prises électriques, pose avant doublage'; }
						else if ( $("#quest_95").val()==139 ) { prixUnitaire=156;prixQuest=(prixUnitaire*parseInt($("#quest_34").val()));text='Prises électriques, pose encastrée'; }
						else if ( $("#quest_95").val()==140 ) { prixUnitaire=119;prixQuest=(prixUnitaire*parseInt($("#quest_34").val()));text='Prises électriques, pose sous goulotte'; }
						else if ( $("#quest_95").val()==141 ) { prixUnitaire=138;prixQuest=(prixUnitaire*parseInt($("#quest_34").val()));text='Prises électriques, pose semi encastrée'; }
						prixCat=prixQuest;
						totalHT=(totalHTancien*1)+prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#panier_6").css('display','');
						$("#panier_6").append('<tr id="trCat_6" class="stot"><th colspan="3">Electricité</th><th>sous-total HT</th><th id="prixCateg_6" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
						$("#panier_6").append('<tr id="trQuest_95_34"><td id="tdLabelQuest_95_34">'+text+'</td><td id="tdUniteQuest_95_34">unité</td><td id="tdQteQuest_95_34" class="n">'+number_format(parseInt($("#quest_34").val()),2,'.','')+'</td><td id="tdPrixUniQuest_95_34" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_95_34" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
					}
				}
			}
			else
			{
				if ( $("#quest_34").val() )
				{
					if ( $("#quest_95").val()!=0 )
					{
						prixAncienCat=$("#prixCateg_6").html(); 
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_95").val()==138 ) { prixUnitaire=101;prixQuest=(prixUnitaire*parseInt($("#quest_34").val()));text='Prises électriques, pose avant doublage'; }
						else if ( $("#quest_95").val()==139 ) { prixUnitaire=156;prixQuest=(prixUnitaire*parseInt($("#quest_34").val()));text='Prises électriques, pose encastrée'; }
						else if ( $("#quest_95").val()==140 ) { prixUnitaire=119;prixQuest=(prixUnitaire*parseInt($("#quest_34").val()));text='Prises électriques, pose sous goulotte'; }
						else if ( $("#quest_95").val()==141 ) { prixUnitaire=138;prixQuest=(prixUnitaire*parseInt($("#quest_34").val()));text='Prises électriques, pose semi encastrée'; }
						if ( $("#trQuest_95_34").size()==0 )
						{
							prixCat=(prixAncienCat*1) + prixQuest;
							totalHT=(totalHTancien*1) + prixQuest;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
							$("#panier_6").append('<tr id="trQuest_95_34"><td id="tdLabelQuest_95_34">'+text+'</td><td id="tdUniteQuest_95_34">unité</td><td id="tdQteQuest_95_34" class="n">'+number_format(parseInt($("#quest_34").val()),2,'.','')+'</td><td id="tdPrixUniQuest_95_34" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_95_34" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
						}
						else
						{
							prixAncienQuest=$("#tdPrixQuest_95_34").html();
							prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
							totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
							$("#tdQteQuest_95_34").html(number_format(parseInt($("#quest_34").val()),2,'.',''));
							$("#tdPrixQuest_95_34").html(number_format(prixQuest,2,'.',''));
						}
					}
					else
					{
						if ( $("#trQuest_95_34").size()==0 )
						{
							$("#panier_6").append('<tr id="trQuest_95_34"><td id="tdLabelQuest_95_34">Donner plus de précisions, en répondant aux questions pour la partie : Eclairage</td><td id="tdUniteQuest_95_34"></td><td id="tdQteQuest_95_34" class="n">0.00</td><td id="tdPrixUniQuest_95_34" class="n">0.00</td><td id="tdPrixQuest_95_34" class="n">0.00</td></tr>');
						}
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_6").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_95_34").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
					$("#trQuest_95_34").remove();
					if ( $("#panier_6").html()=='<tr id="trCat_6" class="stot"><th colspan="3">Electricité</th><th>sous-total HT</th><th id="prixCateg_6" class="n">0.00</th></tr>' ) 
						$("#trCat_6").remove();
				}
			}
		}
		//Partie Electricité --------------- Tableau --------------
		else if ( idQ==35 )
		{
			if ( $("#quest_35").val()!=0 )
			{
				if ( $("#panier_6").html()=="" )
				{
					totalHTancien=$("#totalHT").html();
					if ( $("#quest_35").val()==52 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : Studio avec sdb'; }
					else if ( $("#quest_35").val()==53 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 1 pièce cuisine + sdb'; }
					else if ( $("#quest_35").val()==131 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 2 pièces cuisine + sdb'; }
					else if ( $("#quest_35").val()==132 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 3 pièces cuisine + sdb'; }
					else if ( $("#quest_35").val()==133 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 3 pièces cuisine + 2 sdb'; }
					else if ( $("#quest_35").val()==134 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 4 pièces cuisine + sdb'; }
					else if ( $("#quest_35").val()==135 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 4 pièces cuisine + 2 sdb'; }
					else if ( $("#quest_35").val()==136 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 5 pièces cuisine + 2 sdb'; }
					else if ( $("#quest_35").val()==137 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 6 pièces cuisine + 2 sdb'; }
					prixCat=prixQuest;
					totalHT=(totalHTancien*1)+prixQuest;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#panier_6").css('display','');
					$("#panier_6").append('<tr id="trCat_6" class="stot"><th colspan="3">Electricité</th><th>sous-total HT</th><th id="prixCateg_6" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
					$("#panier_6").append('<tr id="trQuest_35"><td id="tdLabelQuest_35">'+text+'</td><td id="tdUniteQuest_35">unité</td><td id="tdQteQuest_35" class="n">1.00</td><td id="tdPrixUniQuest_35" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_35" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
				}
				else
				{
					if ( $("#trQuest_35").size()==0 )
					{
						prixAncienCat=$("#prixCateg_6").html(); 
						totalHTancien=$("#totalHT").html();
						prixAncienQuest=$("#tdPrixUniQuest_35").html();
						if ( $("#quest_35").val()==52 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : Studio avec sdb'; }
						else if ( $("#quest_35").val()==53 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 1 pièce cuisine + sdb'; }
						else if ( $("#quest_35").val()==131 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 2 pièces cuisine + sdb'; }
						else if ( $("#quest_35").val()==132 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 3 pièces cuisine + sdb'; }
						else if ( $("#quest_35").val()==133 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 3 pièces cuisine + 2 sdb'; }
						else if ( $("#quest_35").val()==134 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 4 pièces cuisine + sdb'; }
						else if ( $("#quest_35").val()==135 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 4 pièces cuisine + 2 sdb'; }
						else if ( $("#quest_35").val()==136 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 5 pièces cuisine + 2 sdb'; }
						else if ( $("#quest_35").val()==137 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 6 pièces cuisine + 2 sdb'; }
						prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
						totalHT=(totalHTancien*1) - (prixAncienQuest*1)  + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
						$("#panier_6").append('<tr id="trQuest_35"><td id="tdLabelQuest_35">'+text+'</td><td id="tdUniteQuest_35">unité</td><td id="tdQteQuest_35" class="n">1.00</td><td id="tdPrixUniQuest_35" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_35" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
					}
					else
					{
						prixAncienCat=$("#prixCateg_6").html(); 
						totalHTancien=$("#totalHT").html();
						prixAncienQuest=$("#tdPrixUniQuest_35").html();
						if ( $("#quest_35").val()==52 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : Studio avec sdb'; }
						else if ( $("#quest_35").val()==53 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 1 pièce cuisine + sdb'; }
						else if ( $("#quest_35").val()==131 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 2 pièces cuisine + sdb'; }
						else if ( $("#quest_35").val()==132 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 3 pièces cuisine + sdb'; }
						else if ( $("#quest_35").val()==133 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 3 pièces cuisine + 2 sdb'; }
						else if ( $("#quest_35").val()==134 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 4 pièces cuisine + sdb'; }
						else if ( $("#quest_35").val()==135 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 4 pièces cuisine + 2 sdb'; }
						else if ( $("#quest_35").val()==136 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 5 pièces cuisine + 2 sdb'; }
						else if ( $("#quest_35").val()==137 ) { prixUnitaire=600;prixQuest=prixUnitaire;text='Tableau électrique : 6 pièces cuisine + 2 sdb'; }
						prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
						totalHT=(totalHTancien*1) - (prixAncienQuest*1)  + prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
						$("#tdLabelQuest_35").html(text);
						$("#tdPrixUniQuest_35").html(number_format(prixQuest,2,'.',''));
					}
				}
			}
			else
			{
				if ( $("#trQuest_35").size()!=0 )
				{
					prixAncienCat=$("#prixCateg_6").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_35").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_6").html(number_format(prixCat,2,'.',''));
					$("#trQuest_35").remove();
					if ( $("#panier_6").html()=='<tr id="trCat_6" class="stot"><th colspan="3">Electricité</th><th>sous-total HT</th><th id="prixCateg_6" class="n">0.00</th></tr>' ) 
						$("#trCat_6").remove();
				}
			}
		}
		//Partie Revêtement de murs et plafond --------------- Peinture intérieure --------------
		else if ( idQ==10 ) 
		{  
			if ( $("#quest_10").val()==0 )
			{
				if ( $("#quest_7").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_10_7_9").html();
					prixAncienQuest_P=$("#tdPrixQuest_10_7_9_P").html();
					prixAncienCat=$("#prixCateg_4").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_10_7_9").html('Donner plus de précisions, en répondant aux questions pour la partie : Peinture intérieure');
					$("#tdUniteQuest_10_7_9").html('');
					$("#tdQteQuest_10_7_9").html('0.00');
					$("#tdPrixUniQuest_10_7_9").html('0.00');
					$("#tdPrixQuest_10_7_9").html('0.00');
					$("#trQuest_10_7_9_P").remove();
				}
			}
			else
			{
				if ( $("#quest_7").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_4").html(); 
					prixAncienQuest=$("#tdPrixQuest_10_7_9").html();
					prixAncienQuest_P=$("#tdPrixQuest_10_7_9_P").html();
					prixUnitaire=21;prixQuest=(prixUnitaire*$("#quest_7").val());
					if ( $("#quest_9").val()==0 ) { text='Fourniture et pose de peinture deux couches, pour des murs'; }
					else if ( $("#quest_9").val()==11 ) { text='Fourniture et pose de peinture deux couches, pour des murs'; }
					else if ( $("#quest_9").val()==12 ) { text='Fourniture et pose de peinture deux couches, pour des plafonds'; } 
					else if ( $("#quest_9").val()==13 ) { text='Fourniture et pose de peinture deux couches, pour les murs et les plafonds'; }
					if ( $("#quest_10").val()==14 ) { prixUnitaire_P=2;prixQuest_P=(prixUnitaire_P*$("#quest_7").val());text_P='Lessivage'; }
					else if ( $("#quest_10").val()==15 ) { prixUnitaire_P=10;prixQuest_P=(prixUnitaire_P*$("#quest_7").val());text_P='Fourniture et pose d\'enduit partiel'; }
					else if ( $("#quest_10").val()==16 ) { prixUnitaire_P=20;prixQuest_P=(prixUnitaire_P*$("#quest_7").val());text_P='Rebouchage, fourniture et pose d\'enduit de lissage complet'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_10_7_9").html(text);
					$("#tdUniteQuest_10_7_9").html('m²');
					$("#tdQteQuest_10_7_9").html(number_format($("#quest_7").val(),2,'.',''));
					$("#tdPrixUniQuest_10_7_9").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_10_7_9").html(number_format(prixQuest,2,'.',''));
					if ( $("#trQuest_10_7_9_P").size()==0 )
					{
						$("#trQuest_10_7_9").after('<tr id="trQuest_10_7_9_P"><td id="tdLabelQuest_10_7_9_P">'+text_P+'</td><td id="tdUniteQuest_10_7_9_P">m²</td><td id="tdQteQuest_10_7_9_P" class="n">'+number_format($("#quest_7").val(),2,'.','')+'</td><td id="tdPrixUniQuest_10_7_9_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_10_7_9_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
					else
					{
						$("#tdLabelQuest_10_7_9_P").html(text_P);
						$("#tdUniteQuest_10_7_9_P").html('m²');
						$("#tdQteQuest_10_7_9_P").html(number_format($("#quest_7").val(),2,'.',''));
						$("#tdPrixUniQuest_10_7_9_P").html(number_format(prixUnitaire_P,2,'.',''));
						$("#tdPrixQuest_10_7_9_P").html(number_format(prixQuest_P,2,'.',''));
					}
				}
			}
		}
		else if ( idQ==7 )
		{
			if ( $("#panier_4").html()=="" )
			{
				if ( $("#quest_7").val() )
				{
					if ( $("#quest_10").val()==0 )
					{
						$("#panier_4").css('display','');
						$("#panier_4").append('<tr id="trCat_4" class="stot"><th colspan="3">Revêtement murs et plafond</th><th>sous-total HT</th><th id="prixCateg_4" class="n">0</th></tr>');
						$("#panier_4").append('<tr id="trQuest_10_7_9"><td id="tdLabelQuest_10_7_9">Donner plus de précisions, en répondant aux questions pour la partie : Peinture intérieure</td><td id="tdUniteQuest_10_7_9"></td><td id="tdQteQuest_10_7_9" class="n">0.00</td><td id="tdPrixUniQuest_10_7_9" class="n">0.00</td><td id="tdPrixQuest_10_7_9" class="n">0.00</td></tr>');
					}
					else
					{
						totalHTancien=$("#totalHT").html();
						prixUnitaire=21;prixQuest=(prixUnitaire*$("#quest_7").val());
						if ( $("#quest_9").val()==0 ) { text='Fourniture et pose de peinture deux couches, pour des murs'; }
						else if ( $("#quest_9").val()==11 ) { text='Fourniture et pose de peinture deux couches, pour des murs'; }
						else if ( $("#quest_9").val()==12 ) { text='Fourniture et pose de peinture deux couches, pour des plafonds'; } 
						else if ( $("#quest_9").val()==13 ) { text='Fourniture et pose de peinture deux couches, pour les murs et les plafonds'; }
						if ( $("#quest_10").val()==14 ) { prixUnitaire_P=2;prixQuest_P=(prixUnitaire_P*$("#quest_7").val());text_P='Lessivage'; }
						else if ( $("#quest_10").val()==15 ) { prixUnitaire_P=10;prixQuest_P=(prixUnitaire_P*$("#quest_7").val());text_P='Fourniture et pose d\'enduit partiel'; }
						else if ( $("#quest_10").val()==16 ) { prixUnitaire_P=20;prixQuest_P=(prixUnitaire_P*$("#quest_7").val());text_P='Rebouchage, fourniture et pose d\'enduit de lissage complet'; }
						prixCat=prixQuest + prixQuest_P;
						totalHT=(totalHTancien*1)+prixQuest+prixQuest_P;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#panier_4").css('display','');
						$("#panier_4").append('<tr id="trCat_4" class="stot"><th colspan="3">Revêtement murs et plafond</th><th>sous-total HT</th><th id="prixCateg_4" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
						$("#panier_4").append('<tr id="trQuest_10_7_9"><td id="tdLabelQuest_10_7_9">'+text+'</td><td id="tdUniteQuest_10_7_9">m²</td><td id="tdQteQuest_10_7_9" class="n">'+number_format($("#quest_7").val(),2,'.','')+'</td><td id="tdPrixUniQuest_10_7_9" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_10_7_9" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
						$("#panier_4").append('<tr id="trQuest_10_7_9_P"><td id="tdLabelQuest_10_7_9_P">'+text_P+'</td><td id="tdUniteQuest_10_7_9_P">m²</td><td id="tdQteQuest_10_7_9_P" class="n">'+number_format($("#quest_7").val(),2,'.','')+'</td><td id="tdPrixUniQuest_10_7_9_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_10_7_9_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
				}
			}
			else
			{
				if ( $("#quest_7").val() )
				{
					if ( $("#quest_10").val()!=0 )
					{
						prixAncienCat=$("#prixCateg_4").html(); 
						totalHTancien=$("#totalHT").html();
						prixUnitaire=21;prixQuest=(prixUnitaire*$("#quest_7").val());
						if ( $("#quest_9").val()==0 ) { text='Fourniture et pose de peinture deux couches, pour des murs'; }
						else if ( $("#quest_9").val()==11 ) { text='Fourniture et pose de peinture deux couches, pour des murs'; }
						else if ( $("#quest_9").val()==12 ) { text='Fourniture et pose de peinture deux couches, pour des plafonds'; } 
						else if ( $("#quest_9").val()==13 ) { text='Fourniture et pose de peinture deux couches, pour les murs et les plafonds'; }
						if ( $("#quest_10").val()==14 ) { prixUnitaire_P=2;prixQuest_P=(prixUnitaire_P*$("#quest_7").val());text_P='Lessivage'; }
						else if ( $("#quest_10").val()==15 ) { prixUnitaire_P=10;prixQuest_P=(prixUnitaire_P*$("#quest_7").val());text_P='Fourniture et pose d\'enduit partiel'; }
						else if ( $("#quest_10").val()==16 ) { prixUnitaire_P=20;prixQuest_P=(prixUnitaire_P*$("#quest_7").val());text_P='Rebouchage, fourniture et pose d\'enduit de lissage complet'; }
						if ( $("#trQuest_10_7_9").size()==0 )
						{
							prixCat=(prixAncienCat*1) + prixQuest + prixQuest_P;
							totalHT=(totalHTancien*1) + prixQuest + prixQuest_P;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
							$("#panier_4").append('<tr id="trQuest_10_7_9"><td id="tdLabelQuest_10_7_9">'+text+'</td><td id="tdUniteQuest_10_7_9">m²</td><td id="tdQteQuest_10_7_9" class="n">'+number_format($("#quest_7").val(),2,'.','')+'</td><td id="tdPrixUniQuest_10_7_9" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_10_7_9" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
							$("#panier_4").append('<tr id="trQuest_10_7_9_P"><td id="tdLabelQuest_10_7_9_P">'+text_P+'</td><td id="tdUniteQuest_10_7_9_P">m²</td><td id="tdQteQuest_10_7_9_P" class="n">'+number_format($("#quest_7").val(),2,'.','')+'</td><td id="tdPrixUniQuest_10_7_9_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_10_7_9_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
						}
						else
						{
							prixAncienQuest=$("#tdPrixQuest_10_7_9").html();
							prixAncienQuest_P=$("#tdPrixQuest_10_7_9_P").html();
							prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
							totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
							$("#tdQteQuest_10_7_9").html(number_format($("#quest_7").val(),2,'.',''));
							$("#tdPrixQuest_10_7_9").html(number_format(prixQuest,2,'.',''));
							$("#tdQteQuest_10_7_9_P").html(number_format($("#quest_7").val(),2,'.',''));
							$("#tdPrixQuest_10_7_9_P").html(number_format(prixQuest_P,2,'.',''));
						}
					}
					else
					{
						if ( $("#trQuest_10_7_9").size()==0 )
						{
							$("#panier_4").append('<tr id="trQuest_10_7_9"><td id="tdLabelQuest_10_7_9">Donner plus de précisions, en répondant aux questions pour la partie : Peinture intérieure</td><td id="tdUniteQuest_10_7_9"></td><td id="tdQteQuest_10_7_9" class="n">0.00</td><td id="tdPrixUniQuest_10_7_9" class="n">0.00</td><td id="tdPrixQuest_10_7_9" class="n">0.00</td></tr>');
						}
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_4").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_10_7_9").html();
					prixAncienQuest_P=$("#tdPrixQuest_10_7_9_P").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
					$("#trQuest_10_7_9").remove();
					$("#trQuest_10_7_9_P").remove();
					if ( $("#panier_4").html()=='<tr id="trCat_4" class="stot"><th colspan="3">Revêtement murs et plafond</th><th>sous-total HT</th><th id="prixCateg_4" class="n">0.00</th></tr>' ) 
						$("#trCat_4").remove();
				}
			}
		}
		else if ( idQ==9 )
		{
			if ( $("#quest_7").val() && $("#quest_10").val()!=0 )
			{
				if ( $("#quest_9").val()==0 ) { text='Fourniture et pose de peinture deux couches, pour des murs'; }
				else if ( $("#quest_9").val()==11 ) { text='Fourniture et pose de peinture deux couches, pour des murs'; }
				else if ( $("#quest_9").val()==12 ) { text='Fourniture et pose de peinture deux couches, pour des plafonds'; } 
				else if ( $("#quest_9").val()==13 ) { text='Fourniture et pose de peinture deux couches, pour les murs et les plafonds'; }
				$("#tdLabelQuest_10_7_9").html(text);
			}
		}
		//Partie Revêtement de murs et plafond --------------- Enduit ou crépis --------------
		else if ( idQ==11 ) 
		{  
			if ( $("#quest_11").val()==0 )
			{
				if ( $("#quest_12").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_11_12").html();
					prixAncienCat=$("#prixCateg_4").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_11_12").html('Donner plus de précisions, en répondant aux questions pour la partie : Enduit ou crépis');
					$("#tdUniteQuest_11_12").html('');
					$("#tdQteQuest_11_12").html('0.00');
					$("#tdPrixUniQuest_11_12").html('0.00');
					$("#tdPrixQuest_11_12").html('0.00');
				}
			}
			else
			{
				if ( $("#quest_12").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_4").html(); 
					prixAncienQuest=$("#tdPrixQuest_11_12").html();
					if ( $("#quest_11").val()==17 ) { prixUnitaire=20;prixQuest=(prixUnitaire*$("#quest_12").val());text='Fourniture et pose d\'enduit intérieur de lissage complet avant peinture'; }
					else if ( $("#quest_11").val()==18 ) { prixUnitaire=25;prixQuest=(prixUnitaire*$("#quest_12").val());text='Fourniture et pose de crépis extérieur projeté'; }
					else if ( $("#quest_11").val()==19 ) { prixUnitaire=28;prixQuest=(prixUnitaire*$("#quest_12").val());text='Fourniture et pose d\'enduit extérieur de finition gratté'; }
					else if ( $("#quest_11").val()==20 ) { prixUnitaire=50;prixQuest=(prixUnitaire*$("#quest_12").val());text='Fourniture et pose d\'enduit extérieur grillagé au mortier'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_11_12").html(text);
					$("#tdUniteQuest_11_12").html('m²');
					$("#tdQteQuest_11_12").html(number_format($("#quest_12").val(),2,'.',''));
					$("#tdPrixUniQuest_11_12").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_11_12").html(number_format(prixQuest,2,'.',''));
				}
			}
		}
		else if ( idQ==12 )
		{
			if ( $("#panier_4").html()=="" )
			{
				if ( $("#quest_12").val() )
				{
					if ( $("#quest_11").val()==0 )
					{
						$("#panier_4").css('display','');
						$("#panier_4").append('<tr id="trCat_4" class="stot"><th colspan="3">Revêtement de murs et plafond</th><th>sous-total HT</th><th id="prixCateg_4" class="n">0</th></tr>');
						$("#panier_4").append('<tr id="trQuest_11_12"><td id="tdLabelQuest_11_12">Donner plus de précisions, en répondant aux questions pour la partie : Enduit ou crépis</td><td id="tdUniteQuest_11_12"></td><td id="tdQteQuest_11_12" class="n">0.00</td><td id="tdPrixUniQuest_11_12" class="n">0.00</td><td id="tdPrixQuest_11_12" class="n">0.00</td></tr>');
					}
					else
					{
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_11").val()==17 ) { prixUnitaire=20;prixQuest=(prixUnitaire*$("#quest_12").val());text='Fourniture et pose d\'enduit intérieur de lissage complet avant peinture'; }
						else if ( $("#quest_11").val()==18 ) { prixUnitaire=25;prixQuest=(prixUnitaire*$("#quest_12").val());text='Fourniture et pose de crépis extérieur projeté'; }
						else if ( $("#quest_11").val()==19 ) { prixUnitaire=28;prixQuest=(prixUnitaire*$("#quest_12").val());text='Fourniture et pose d\'enduit extérieur de finition gratté'; }
						else if ( $("#quest_11").val()==20 ) { prixUnitaire=50;prixQuest=(prixUnitaire*$("#quest_12").val());text='Fourniture et pose d\'enduit extérieur grillagé au mortier'; }
						prixCat=prixQuest;
						totalHT=(totalHTancien*1)+prixQuest;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#panier_4").css('display','');
						$("#panier_4").append('<tr id="trCat_4" class="stot"><th colspan="3">Revêtement de murs et plafond</th><th>sous-total HT</th><th id="prixCateg_4" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
						$("#panier_4").append('<tr id="trQuest_11_12"><td id="tdLabelQuest_11_12">'+text+'</td><td id="tdUniteQuest_11_12">m²</td><td id="tdQteQuest_11_12" class="n">'+number_format($("#quest_12").val(),2,'.','')+'</td><td id="tdPrixUniQuest_11_12" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_11_12" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
					}
				}
			}
			else
			{
				if ( $("#quest_12").val() )
				{
					if ( $("#quest_11").val()!=0 )
					{
						prixAncienCat=$("#prixCateg_4").html(); 
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_11").val()==17 ) { prixUnitaire=20;prixQuest=(prixUnitaire*$("#quest_12").val());text='Fourniture et pose d\'enduit intérieur de lissage complet avant peinture'; }
						else if ( $("#quest_11").val()==18 ) { prixUnitaire=25;prixQuest=(prixUnitaire*$("#quest_12").val());text='Fourniture et pose de crépis extérieur projeté'; }
						else if ( $("#quest_11").val()==19 ) { prixUnitaire=28;prixQuest=(prixUnitaire*$("#quest_12").val());text='Fourniture et pose d\'enduit extérieur de finition gratté'; }
						else if ( $("#quest_11").val()==20 ) { prixUnitaire=50;prixQuest=(prixUnitaire*$("#quest_12").val());text='Fourniture et pose d\'enduit extérieur grillagé au mortier'; }
						if ( $("#trQuest_11_12").size()==0 )
						{
							prixCat=(prixAncienCat*1) + prixQuest;
							totalHT=(totalHTancien*1) + prixQuest;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
							$("#panier_4").append('<tr id="trQuest_11_12"><td id="tdLabelQuest_11_12">'+text+'</td><td id="tdUniteQuest_11_12">m²</td><td id="tdQteQuest_11_12" class="n">'+number_format($("#quest_12").val(),2,'.','')+'</td><td id="tdPrixUniQuest_11_12" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_11_12" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
						}
						else
						{
							prixAncienQuest=$("#tdPrixQuest_11_12").html();
							prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuest;
							totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuest;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
							$("#tdQteQuest_11_12").html(number_format($("#quest_12").val(),2,'.',''));
							$("#tdPrixQuest_11_12").html(number_format(prixQuest,2,'.',''));
						}
					}
					else
					{
						if ( $("#trQuest_11_12").size()==0 )
						{
							$("#panier_4").append('<tr id="trQuest_11_12"><td id="tdLabelQuest_11_12">Donner plus de précisions, en répondant aux questions pour la partie : Enduit ou crépis</td><td id="tdUniteQuest_11_12"></td><td id="tdQteQuest_11_12" class="n">0.00</td><td id="tdPrixUniQuest_11_12" class="n">0.00</td><td id="tdPrixQuest_11_12" class="n">0.00</td></tr>');
						}
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_4").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_11_12").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
					$("#trQuest_11_12").remove();
					if ( $("#panier_4").html()=='<tr id="trCat_4" class="stot"><th colspan="3">Revêtement de murs et plafond</th><th>sous-total HT</th><th id="prixCateg_4" class="n">0.00</th></tr>' ) 
						$("#trCat_4").remove();
				}
			}
		}
		//Partie Revêtement de murs et plafond --------------- Papier-peint --------------
		else if ( idQ==14 ) 
		{  
			if ( $("#quest_14").val()==0 )
			{
				if ( $("#quest_13").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_14_13").html();
					if ( $("#trQuest_14_13_P").size()!=0 )
					{
						prixAncienQuest_P=$("#tdPrixQuest_14_13_P").html();
						prixAncienQuest=(prixAncienQuest*1) + (prixAncienQuest_P*1);
					}
					prixAncienCat=$("#prixCateg_4").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_14_13").html('Donner plus de précisions, en répondant aux questions pour la partie : Papier-peint');
					$("#tdUniteQuest_14_13").html('');
					$("#tdQteQuest_14_13").html('0.00');
					$("#tdPrixUniQuest_14_13").html('0.00');
					$("#tdPrixQuest_14_13").html('0.00');
					if ( $("#trQuest_14_13_P").size()!=0 )
					{
						$("#trQuest_14_13_P").remove();
					}
				}
			}
			else
			{
				if ( $("#quest_13").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_4").html(); 
					prixAncienQuest=$("#tdPrixQuest_14_13").html();
					if ( $("#trQuest_14_13_P").size()!=0 )
					{
						prixAncienQuest_P=$("#tdPrixQuest_14_13_P").html();
						prixAncienQuest=(prixAncienQuest*1) + (prixAncienQuest_P*1);
					}
					if ( $("#quest_14").val()==21 ) { prixUnitaire=21.5;prixQuest=(prixUnitaire*$("#quest_13").val());text='Fourniture et pose de papier peint';prixQuestt=prixQuest; }
					else if ( $("#quest_14").val()==22 ) { prixUnitaire=21.5;prixQuest=(prixUnitaire*$("#quest_13").val());text='Fourniture et pose de papier peint';prixUnitaire_P=8.5;prixQuest_P=(prixUnitaire_P*$("#quest_13").val());text_P='Dépose de papier peint';prixQuestt=prixQuest+prixQuest_P; }
					else if ( $("#quest_14").val()==23 ) { prixUnitaire=8.5;prixQuest=(prixUnitaire*$("#quest_13").val());text='Dépose de papier peint';prixQuestt=prixQuest; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuestt;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuestt;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_14_13").html(text);
					$("#tdUniteQuest_14_13").html('m²');
					$("#tdQteQuest_14_13").html(number_format($("#quest_13").val(),2,'.',''));
					$("#tdPrixUniQuest_14_13").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_14_13").html(number_format(prixQuest,2,'.',''));
					if ( $("#trQuest_14_13_P").size()!=0 )
					{
						$("#trQuest_14_13_P").remove();
					}
					else
					{
						if ( $("#quest_14").val()==22 )
						{
							$("#trQuest_14_13").after('<tr id="trQuest_14_13_P"><td id="tdLabelQuest_14_13_P">'+text_P+'</td><td id="tdUniteQuest_14_13_P">m²</td><td id="tdQteQuest_14_13_P" class="n">'+number_format($("#quest_13").val(),2,'.','')+'</td><td id="tdPrixUniQuest_14_13_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_14_13_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
						}
					}
				}
			}
		}
		else if ( idQ==13 )
		{
			if ( $("#panier_4").html()=="" )
			{
				if ( $("#quest_13").val() )
				{
					if ( $("#quest_14").val()==0 )
					{
						$("#panier_4").css('display','');
						$("#panier_4").append('<tr id="trCat_4" class="stot"><th colspan="3">Revêtement de murs et plafond</th><th>sous-total HT</th><th id="prixCateg_4" class="n">0</th></tr>');
						$("#panier_4").append('<tr id="trQuest_14_13"><td id="tdLabelQuest_14_13">Donner plus de précisions, en répondant aux questions pour la partie : Papier-peint</td><td id="tdUniteQuest_14_13"></td><td id="tdQteQuest_14_13" class="n">0.00</td><td id="tdPrixUniQuest_14_13" class="n">0.00</td><td id="tdPrixQuest_14_13" class="n">0.00</td></tr>');
					}
					else
					{
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_14").val()==21 ) { prixUnitaire=21.5;prixQuest=(prixUnitaire*$("#quest_13").val());text='Fourniture et pose de papier peint';prixQuestt=prixQuest; }
						else if ( $("#quest_14").val()==22 ) { prixUnitaire=21.5;prixQuest=(prixUnitaire*$("#quest_13").val());text='Fourniture et pose de papier peint';prixUnitaire_P=8.5;prixQuest_P=(prixUnitaire_P*$("#quest_13").val());text_P='Dépose de papier peint';prixQuestt=prixQuest+prixQuest_P; }
						else if ( $("#quest_14").val()==23 ) { prixUnitaire=8.5;prixQuest=(prixUnitaire*$("#quest_13").val());text='Dépose de papier peint';prixQuestt=prixQuest; }
						prixCat=prixQuestt;
						totalHT=(totalHTancien*1)+prixQuestt;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#panier_4").css('display','');
						$("#panier_4").append('<tr id="trCat_4" class="stot"><th colspan="3">Revêtement de murs et plafond</th><th>sous-total HT</th><th id="prixCateg_4" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
						$("#panier_4").append('<tr id="trQuest_14_13"><td id="tdLabelQuest_14_13">'+text+'</td><td id="tdUniteQuest_14_13">m²</td><td id="tdQteQuest_14_13" class="n">'+number_format($("#quest_13").val(),2,'.','')+'</td><td id="tdPrixUniQuest_14_13" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_14_13" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
						if ( $("#quest_14").val()==22 )
						{
							$("#panier_4").append('<tr id="trQuest_14_13_P"><td id="tdLabelQuest_14_13_P">'+text_P+'</td><td id="tdUniteQuest_14_13_P">m²</td><td id="tdQteQuest_14_13_P" class="n">'+number_format($("#quest_13").val(),2,'.','')+'</td><td id="tdPrixUniQuest_14_13_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_14_13_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
						}
					}
				}
			}
			else
			{
				if ( $("#quest_13").val() )
				{
					if ( $("#quest_14").val()!=0 )
					{
						prixAncienCat=$("#prixCateg_4").html(); 
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_14").val()==21 ) { prixUnitaire=21.5;prixQuest=(prixUnitaire*$("#quest_13").val());text='Fourniture et pose de papier peint';prixQuestt=prixQuest; }
						else if ( $("#quest_14").val()==22 ) { prixUnitaire=21.5;prixQuest=(prixUnitaire*$("#quest_13").val());text='Fourniture et pose de papier peint';prixUnitaire_P=8.5;prixQuest_P=(prixUnitaire_P*$("#quest_13").val());text_P='Dépose de papier peint';prixQuestt=prixQuest+prixQuest_P; }
						else if ( $("#quest_14").val()==23 ) { prixUnitaire=8.5;prixQuest=(prixUnitaire*$("#quest_13").val());text='Dépose de papier peint';prixQuestt=prixQuest; }
						if ( $("#trQuest_14_13").size()==0 )
						{
							prixCat=(prixAncienCat*1) + prixQuestt;
							totalHT=(totalHTancien*1) + prixQuestt;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
							$("#panier_4").append('<tr id="trQuest_14_13"><td id="tdLabelQuest_14_13">'+text+'</td><td id="tdUniteQuest_14_13">m²</td><td id="tdQteQuest_14_13" class="n">'+number_format($("#quest_13").val(),2,'.','')+'</td><td id="tdPrixUniQuest_14_13" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_14_13" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
							if ( $("#quest_14").val()==22 )
							{
								$("#panier_4").append('<tr id="trQuest_14_13_P"><td id="tdLabelQuest_14_13_P">'+text_P+'</td><td id="tdUniteQuest_14_13_P">m²</td><td id="tdQteQuest_14_13_P" class="n">'+number_format($("#quest_13").val(),2,'.','')+'</td><td id="tdPrixUniQuest_14_13_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_14_13_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
							}
						}
						else
						{
							prixAncienQuest=$("#tdPrixQuest_14_13").html();
							if ( $("#trQuest_14_13_P").size()!=0 )
							{
								prixAncienQuest_P=$("#tdPrixQuest_14_13_P").html();
								prixAncienQuest=(prixAncienQuest*1) + (prixAncienQuest_P*1);
							}
							prixCat=(prixAncienCat*1) - (prixAncienQuest*1) + prixQuestt;
							totalHT=(totalHTancien*1) - (prixAncienQuest*1) + prixQuestt;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
							$("#tdQteQuest_14_13").html(number_format($("#quest_13").val(),2,'.',''));
							$("#tdPrixQuest_14_13").html(number_format(prixQuest,2,'.',''));
							if ( $("#quest_14").val()==22 )
							{
								$("#tdQteQuest_14_13_P").html(number_format($("#quest_13").val(),2,'.',''));
								$("#tdPrixQuest_14_13_P").html(number_format(prixQuest_P,2,'.',''));
							}
						}
					}
					else
					{
						if ( $("#trQuest_14_13").size()==0 )
						{
							$("#panier_4").append('<tr id="trQuest_14_13"><td id="tdLabelQuest_14_13">Donner plus de précisions, en répondant aux questions pour la partie : Papier-peint</td><td id="tdUniteQuest_14_13"></td><td id="tdQteQuest_14_13" class="n">0.00</td><td id="tdPrixUniQuest_14_13" class="n">0.00</td><td id="tdPrixQuest_14_13" class="n">0.00</td></tr>');
						}
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_4").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_14_13").html();
					if ( $("#trQuest_14_13_P").size()!=0 )
					{
						prixAncienQuest_P=$("#tdPrixQuest_14_13_P").html();
						prixAncienQuest=(prixAncienQuest*1) + (prixAncienQuest_P*1);
					}
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
					$("#trQuest_14_13").remove();
					if ( $("#trQuest_14_13_P").size()!=0 )
					{
						$("#trQuest_14_13_P").remove();
					}
					if ( $("#panier_4").html()=='<tr id="trCat_4" class="stot"><th colspan="3">Revêtement de murs et plafond</th><th>sous-total HT</th><th id="prixCateg_4" class="n">0.00</th></tr>' ) 
						$("#trCat_4").remove();
				}
			}
		}
		//Partie Revêtement de murs et plafond --------------- Extérieur, ravalement --------------
		else if ( idQ==15 ) 
		{  
			if ( $("#quest_15").val()==0 )
			{
				if ( $("#quest_16").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_15_16").html();
					prixAncienQuest_P=$("#tdPrixQuest_15_16_P").html();
					prixAncienCat=$("#prixCateg_4").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_15_16").html('Donner plus de précisions, en répondant aux questions pour la partie : Extérieur, ravalement');
					$("#tdUniteQuest_15_16").html('');
					$("#tdQteQuest_15_16").html('0.00');
					$("#tdPrixUniQuest_15_16").html('0.00');
					$("#tdPrixQuest_15_16").html('0.00');
					$("#trQuest_15_16_P").remove();
				}
			}
			else
			{
				if ( $("#quest_16").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_4").html(); 
					prixAncienQuest=$("#tdPrixQuest_15_16").html();
					prixAncienQuest_P=$("#tdPrixQuest_15_16_P").html();
					if ( $("#quest_15").val()==24 ) { prixUnitaire=70;prixQuest=(prixUnitaire*$("#quest_16").val());text='Hydro-gommage et peinture extérieure, avec échafaudage'; }
					else if ( $("#quest_15").val()==25 ) { prixUnitaire=72;prixQuest=(prixUnitaire*$("#quest_16").val());text='Hydro-gommage et rejointoillage de murs extérieurs, avec échafaudage'; }
					else if ( $("#quest_15").val()==26 ) { prixUnitaire=50;prixQuest=(prixUnitaire*$("#quest_16").val());text='Fourniture et pose de peinture extérieure, avec échafaudage'; }
					else if ( $("#quest_15").val()==27 ) { prixUnitaire=59;prixQuest=(prixUnitaire*$("#quest_16").val());text='Hydro-gommage extérieur, avec échafaudage'; }
					else if ( $("#quest_15").val()==28 ) { prixUnitaire=55;prixQuest=(prixUnitaire*$("#quest_16").val());text='Rejointoillage de mur extérieur, avec échafaudage'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + 1500;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + 1500;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_15_16").html(text);
					$("#tdUniteQuest_15_16").html('m²');
					$("#tdQteQuest_15_16").html(number_format($("#quest_16").val(),2,'.',''));
					$("#tdPrixUniQuest_15_16").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_15_16").html(number_format(prixQuest,2,'.',''));
					if ( $("#trQuest_15_16_P").size()==0 )
					{
						$("#trQuest_15_16").after('<tr id="trQuest_15_16_P"><td id="tdLabelQuest_15_16_P">Echafaudage</td><td id="tdUniteQuest_15_16_P">unité</td><td id="tdQteQuest_15_16_P" class="n">1.00</td><td id="tdPrixUniQuest_15_16_P" class="n">1500</td><td id="tdPrixQuest_15_16_P" class="n">1500</td></tr>');
					}
				}
			}
		}
		else if ( idQ==16 )
		{
			if ( $("#panier_4").html()=="" )
			{
				if ( $("#quest_16").val() )
				{
					if ( $("#quest_15").val()==0 )
					{
						$("#panier_4").css('display','');
						$("#panier_4").append('<tr id="trCat_4" class="stot"><th colspan="3">Revêtement de murs et plafond</th><th>sous-total HT</th><th id="prixCateg_4" class="n">0</th></tr>');
						$("#panier_4").append('<tr id="trQuest_15_16"><td id="tdLabelQuest_15_16">Donner plus de précisions, en répondant aux questions pour la partie : Extérieur, ravalement</td><td id="tdUniteQuest_15_16"></td><td id="tdQteQuest_15_16" class="n">0.00</td><td id="tdPrixUniQuest_15_16" class="n">0.00</td><td id="tdPrixQuest_15_16" class="n">0.00</td></tr>');
					}
					else
					{
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_15").val()==24 ) { prixUnitaire=70;prixQuest=(prixUnitaire*$("#quest_16").val());text='Hydro-gommage et peinture extérieure, avec échafaudage'; }
						else if ( $("#quest_15").val()==25 ) { prixUnitaire=72;prixQuest=(prixUnitaire*$("#quest_16").val());text='Hydro-gommage et rejointoillage de murs extérieurs, avec échafaudage'; }
						else if ( $("#quest_15").val()==26 ) { prixUnitaire=50;prixQuest=(prixUnitaire*$("#quest_16").val());text='Fourniture et pose de peinture extérieure, avec échafaudage'; }
						else if ( $("#quest_15").val()==27 ) { prixUnitaire=59;prixQuest=(prixUnitaire*$("#quest_16").val());text='Hydro-gommage extérieur, avec échafaudage'; }
						else if ( $("#quest_15").val()==28 ) { prixUnitaire=55;prixQuest=(prixUnitaire*$("#quest_16").val());text='Rejointoillage de mur extérieur, avec échafaudage'; }
						prixCat=prixQuest + 1500;
						totalHT=(totalHTancien*1)+prixQuest+1500;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#panier_4").css('display','');
						$("#panier_4").append('<tr id="trCat_4" class="stot"><th colspan="3">Revêtement de murs et plafond</th><th>sous-total HT</th><th id="prixCateg_4" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
						$("#panier_4").append('<tr id="trQuest_15_16"><td id="tdLabelQuest_15_16">'+text+'</td><td id="tdUniteQuest_15_16">m²</td><td id="tdQteQuest_15_16" class="n">'+number_format($("#quest_16").val(),2,'.','')+'</td><td id="tdPrixUniQuest_15_16" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_15_16" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
						$("#panier_4").append('<tr id="trQuest_15_16_P"><td id="tdLabelQuest_15_16_P">Echafaudage</td><td id="tdUniteQuest_15_16_P">unité</td><td id="tdQteQuest_15_16_P" class="n">1.00</td><td id="tdPrixUniQuest_15_16_P" class="n">1500</td><td id="tdPrixQuest_15_16_P" class="n">1500</td></tr>');
					}
				}
			}
			else
			{
				if ( $("#quest_16").val() )
				{
					if ( $("#quest_15").val()!=0 )
					{
						prixAncienCat=$("#prixCateg_4").html(); 
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_15").val()==24 ) { prixUnitaire=70;prixQuest=(prixUnitaire*$("#quest_16").val());text='Hydro-gommage et peinture extérieure, avec échafaudage'; }
						else if ( $("#quest_15").val()==25 ) { prixUnitaire=72;prixQuest=(prixUnitaire*$("#quest_16").val());text='Hydro-gommage et rejointoillage de murs extérieurs, avec échafaudage'; }
						else if ( $("#quest_15").val()==26 ) { prixUnitaire=50;prixQuest=(prixUnitaire*$("#quest_16").val());text='Fourniture et pose de peinture extérieure, avec échafaudage'; }
						else if ( $("#quest_15").val()==27 ) { prixUnitaire=59;prixQuest=(prixUnitaire*$("#quest_16").val());text='Hydro-gommage extérieur, avec échafaudage'; }
						else if ( $("#quest_15").val()==28 ) { prixUnitaire=55;prixQuest=(prixUnitaire*$("#quest_16").val());text='Rejointoillage de mur extérieur, avec échafaudage'; }
						if ( $("#trQuest_15_16").size()==0 )
						{
							prixCat=(prixAncienCat*1) + prixQuest + 1500;
							totalHT=(totalHTancien*1) + prixQuest + 1500;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
							$("#panier_4").append('<tr id="trQuest_15_16"><td id="tdLabelQuest_15_16">'+text+'</td><td id="tdUniteQuest_15_16">m²</td><td id="tdQteQuest_15_16" class="n">'+number_format($("#quest_16").val(),2,'.','')+'</td><td id="tdPrixUniQuest_15_16" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_15_16" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
							$("#panier_4").append('<tr id="trQuest_15_16_P"><td id="tdLabelQuest_15_16_P">Echafaudage</td><td id="tdUniteQuest_15_16_P">unité</td><td id="tdQteQuest_15_16_P" class="n">1.00</td><td id="tdPrixUniQuest_15_16_P" class="n">1500</td><td id="tdPrixQuest_15_16_P" class="n">1500</td></tr>');
						}
						else
						{
							prixAncienQuest=$("#tdPrixQuest_15_16").html();
							prixAncienQuest_P=$("#tdPrixQuest_15_16_P").html();
							prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + 1500;
							totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + 1500;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
							$("#tdQteQuest_15_16").html(number_format($("#quest_16").val(),2,'.',''));
							$("#tdPrixQuest_15_16").html(number_format(prixQuest,2,'.',''));
							if ( $("#trQuest_15_16_P").size()==0 )
							{
								$("#trQuest_15_16").after('<tr id="trQuest_15_16_P"><td id="tdLabelQuest_15_16_P">Echafaudage</td><td id="tdUniteQuest_15_16_P">unité</td><td id="tdQteQuest_15_16_P" class="n">1.00</td><td id="tdPrixUniQuest_15_16_P" class="n">1500</td><td id="tdPrixQuest_15_16_P" class="n">1500</td></tr>');
							}
						}
					}
					else
					{
						if ( $("#trQuest_15_16").size()==0 )
						{
							$("#panier_4").append('<tr id="trQuest_15_16"><td id="tdLabelQuest_15_16">Donner plus de précisions, en répondant aux questions pour la partie : Extérieur, ravalement</td><td id="tdUniteQuest_15_16"></td><td id="tdQteQuest_15_16" class="n">0.00</td><td id="tdPrixUniQuest_15_16" class="n">0.00</td><td id="tdPrixQuest_15_16" class="n">0.00</td></tr>');
						}
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_4").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_15_16").html();
					prixAncienQuest_P=$("#tdPrixQuest_15_16_P").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_4").html(number_format(prixCat,2,'.',''));
					$("#trQuest_15_16").remove();
					$("#trQuest_15_16_P").remove();
					if ( $("#panier_4").html()=='<tr id="trCat_4" class="stot"><th colspan="3">Revêtement de murs et plafond</th><th>sous-total HT</th><th id="prixCateg_4" class="n">0.00</th></tr>' ) 
						$("#trCat_4").remove();
				}
			}
		}
		//Partie Menuiserie --------------- Généralités -------------
		/*else if ( idQ==46 ) 
		{  
			if ( $("#quest_46").val()==0 )
			{
				if ( $("#quest_47").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_46_47").html();
					prixAncienQuest_P=$("#tdPrixQuest_46_47_P").html();
					prixAncienCat=$("#prixCateg_2").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_46_47").html('Donner plus de précisions, en répondant aux questions pour la partie : Généralités');
					$("#tdUniteQuest_46_47").html('');
					$("#tdQteQuest_46_47").html('0.00');
					$("#tdPrixUniQuest_46_47").html('0.00');
					$("#tdPrixQuest_46_47").html('0.00');
					$("#trQuest_46_47_P").remove();
				}
				if ( $("#quest_48").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_46_48").html();
					prixAncienQuest_P=$("#tdPrixQuest_46_48_P").html();
					prixAncienCat=$("#prixCateg_2").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_46_48").html('Donner plus de précisions, en répondant aux questions pour la partie : Généralités');
					$("#tdUniteQuest_46_48").html('');
					$("#tdQteQuest_46_48").html('0.00');
					$("#tdPrixUniQuest_46_48").html('0.00');
					$("#tdPrixQuest_46_48").html('0.00');
					$("#trQuest_46_48_P").remove();
				}
				if ( $("#quest_51").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_46_51").html();
					prixAncienQuest_P=$("#tdPrixQuest_46_51_P").html();
					prixAncienCat=$("#prixCateg_2").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_46_51").html('Donner plus de précisions, en répondant aux questions pour la partie : Généralités');
					$("#tdUniteQuest_46_51").html('');
					$("#tdQteQuest_46_51").html('0.00');
					$("#tdPrixUniQuest_46_51").html('0.00');
					$("#tdPrixQuest_46_51").html('0.00');
					$("#trQuest_46_51_P").remove();
				}
				if ( $("#quest_52").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_46_52").html();
					prixAncienQuest_P=$("#tdPrixQuest_46_52_P").html();
					prixAncienCat=$("#prixCateg_2").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_46_52").html('Donner plus de précisions, en répondant aux questions pour la partie : Généralités');
					$("#tdUniteQuest_46_52").html('');
					$("#tdQteQuest_46_52").html('0.00');
					$("#tdPrixUniQuest_46_52").html('0.00');
					$("#tdPrixQuest_46_52").html('0.00');
					$("#trQuest_46_52_P").remove();
				}
				if ( $("#quest_49").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_46_49").html();
					prixAncienQuest_P=$("#tdPrixQuest_46_49_P").html();
					prixAncienCat=$("#prixCateg_2").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_46_49").html('Donner plus de précisions, en répondant aux questions pour la partie : Généralités');
					$("#tdUniteQuest_46_49").html('');
					$("#tdQteQuest_46_49").html('0.00');
					$("#tdPrixUniQuest_46_49").html('0.00');
					$("#tdPrixQuest_46_49").html('0.00');
					$("#trQuest_46_49_P").remove();
				}
				if ( $("#quest_50").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_46_50").html();
					prixAncienQuest_P=$("#tdPrixQuest_46_50_P").html();
					prixAncienCat=$("#prixCateg_2").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_46_50").html('Donner plus de précisions, en répondant aux questions pour la partie : Généralités');
					$("#tdUniteQuest_46_50").html('');
					$("#tdQteQuest_46_50").html('0.00');
					$("#tdPrixUniQuest_46_50").html('0.00');
					$("#tdPrixQuest_46_50").html('0.00');
					$("#trQuest_46_50_P").remove();
				}
			}
			else
			{
				if ( $("#quest_47").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_2").html(); 
					prixAncienQuest=$("#tdPrixQuest_46_47").html();
					prixAncienQuest_P=$("#tdPrixQuest_46_47_P").html();
					if ( $("#quest_46").val()==54 ) { prixUnitaire=646.5;prixQuest=(prixUnitaire*parseInt($("#quest_47").val()));text='Fourniture de petite fenêtre en bois';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_47").val()));text_P='Pose en rénovation sur bati sain de petite fenêtre en bois'; }
					else if ( $("#quest_46").val()==55 ) { prixUnitaire=614.5;prixQuest=(prixUnitaire*parseInt($("#quest_47").val()));text='Fourniture de petite fenêtre en ALU';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_47").val()));text_P='Pose en rénovation sur bati sain de petite fenêtre en ALU'; }
					else if ( $("#quest_46").val()==56 ) { prixUnitaire=485;prixQuest=(prixUnitaire*parseInt($("#quest_47").val()));text='Fourniture de petite fenêtre en PVC';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_47").val()));text_P='Pose en rénovation sur bati sain de petite fenêtre en PVC'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_46_47").html(text);
					$("#tdUniteQuest_46_47").html('unité');
					$("#tdQteQuest_46_47").html(number_format(parseInt($("#quest_47").val()),2,'.',''));
					$("#tdPrixUniQuest_46_47").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_46_47").html(number_format(prixQuest,2,'.',''));
					if ( $("#trQuest_46_47_P").size()==0 )
					{
						$("#trQuest_46_47").after('<tr id="trQuest_46_47_P"><td id="tdLabelQuest_46_47_P">'+text_P+'</td><td id="tdUniteQuest_46_47_P">unité</td><td id="tdQteQuest_46_47_P" class="n">'+number_format(parseInt($("#quest_47").val()),2,'.','')+'</td><td id="tdPrixUniQuest_46_47_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_46_47_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
					else
					{
						$("#tdLabelQuest_46_47_P").html(text_P);
						$("#tdUniteQuest_46_47_P").html('unité');
						$("#tdQteQuest_46_47_P").html(number_format(parseInt($("#quest_47").val()),2,'.',''));
						$("#tdPrixUniQuest_46_47_P").html(number_format(prixUnitaire_P,2,'.',''));
						$("#tdPrixQuest_46_47_P").html(number_format(prixQuest_P,2,'.',''));
					}
				}
				if ( $("#quest_48").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_2").html(); 
					prixAncienQuest=$("#tdPrixQuest_46_48").html();
					prixAncienQuest_P=$("#tdPrixQuest_46_48_P").html();
					if ( $("#quest_46").val()==54 ) { prixUnitaire=953.1;prixQuest=(prixUnitaire*parseInt($("#quest_48").val()));text='Fourniture de fenêtre de taille standard en bois';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_48").val()));text_P='Pose en rénovation sur bati sain de fenêtre de taille standard en bois'; }
					else if ( $("#quest_46").val()==55 ) { prixUnitaire=905.9;prixQuest=(prixUnitaire*parseInt($("#quest_48").val()));text='Fourniture de fenêtre de taille standard en ALU';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_48").val()));text_P='Pose en rénovation sur bati sain de fenêtre de taille standard en ALU'; }
					else if ( $("#quest_46").val()==56 ) { prixUnitaire=715;prixQuest=(prixUnitaire*parseInt($("#quest_48").val()));text='Fourniture de fenêtre de taille standard en PVC';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_48").val()));text_P='Pose en rénovation sur bati sain de fenêtre de taille standard en PVC'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_46_48").html(text);
					$("#tdUniteQuest_46_48").html('unité');
					$("#tdQteQuest_46_48").html(number_format(parseInt($("#quest_47").val()),2,'.',''));
					$("#tdPrixUniQuest_46_48").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_46_48").html(number_format(prixQuest,2,'.',''));
					if ( $("#trQuest_46_48_P").size()==0 )
					{
						$("#trQuest_46_48").after('<tr id="trQuest_46_48_P"><td id="tdLabelQuest_46_48_P">'+text_P+'</td><td id="tdUniteQuest_46_48_P">unité</td><td id="tdQteQuest_46_48_P" class="n">'+number_format(parseInt($("#quest_48").val()),2,'.','')+'</td><td id="tdPrixUniQuest_46_48_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_46_48_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
					else
					{
						$("#tdLabelQuest_46_48_P").html(text_P);
						$("#tdUniteQuest_46_48_P").html('unité');
						$("#tdQteQuest_46_48_P").html(number_format(parseInt($("#quest_48").val()),2,'.',''));
						$("#tdPrixUniQuest_46_48_P").html(number_format(prixUnitaire_P,2,'.',''));
						$("#tdPrixQuest_46_48_P").html(number_format(prixQuest_P,2,'.',''));
					}
				}
				if ( $("#quest_51").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_2").html(); 
					prixAncienQuest=$("#tdPrixQuest_46_51").html();
					prixAncienQuest_P=$("#tdPrixQuest_46_51_P").html();
					if ( $("#quest_46").val()==54 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_51").val()));text='Fourniture de bloc porte intérieur en bois ';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_51").val()));text_P='Pose en rénovation sur bati sain de bloc porte en bois'; }
					else if ( $("#quest_46").val()==55 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_51").val()));text='Fourniture de bloc porte intérieur en ALU';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_51").val()));text_P='Pose en rénovation sur bati sain de bloc porte en ALU'; }
					else if ( $("#quest_46").val()==56 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_51").val()));text='Fourniture de bloc porte intérieur en PVC';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_51").val()));text_P='Pose en rénovation sur bati sain de bloc porte en PVC'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_46_51").html(text);
					$("#tdUniteQuest_46_51").html('unité');
					$("#tdQteQuest_46_51").html(number_format(parseInt($("#quest_47").val()),2,'.',''));
					$("#tdPrixUniQuest_46_51").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_46_51").html(number_format(prixQuest,2,'.',''));
					if ( $("#trQuest_46_51_P").size()==0 )
					{
						$("#trQuest_46_51").after('<tr id="trQuest_46_51_P"><td id="tdLabelQuest_46_51_P">'+text_P+'</td><td id="tdUniteQuest_46_51_P">unité</td><td id="tdQteQuest_46_51_P" class="n">'+number_format($("#quest_51").val(),2,'.','')+'</td><td id="tdPrixUniQuest_46_51_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_46_51_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
					else
					{
						$("#tdLabelQuest_46_51_P").html(text_P);
						$("#tdUniteQuest_46_51_P").html('unité');
						$("#tdQteQuest_46_51_P").html(number_format($("#quest_51").val(),2,'.',''));
						$("#tdPrixUniQuest_46_51_P").html(number_format(prixUnitaire_P,2,'.',''));
						$("#tdPrixQuest_46_51_P").html(number_format(prixQuest_P,2,'.',''));
					}
				}
				if ( $("#quest_52").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_2").html(); 
					prixAncienQuest=$("#tdPrixQuest_46_52").html();
					prixAncienQuest_P=$("#tdPrixQuest_46_52_P").html();
					if ( $("#quest_46").val()==54 ) { prixUnitaire=1999.5;prixQuest=(prixUnitaire*parseInt($("#quest_52").val()));text='Fourniture de porte extérieure en bois';prixUnitaire_P=160;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_52").val()));text_P='Pose en rénovation sur bati sain de porte extérieure bois'; }
					else if ( $("#quest_46").val()==55 ) { prixUnitaire=1999.5;prixQuest=(prixUnitaire*parseInt($("#quest_52").val()));text='Fourniture de porte extérieure en ALU';prixUnitaire_P=160;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_52").val()));text_P='Pose en rénovation sur bati sain de porte extérieure en ALU'; }
					else if ( $("#quest_46").val()==56 ) { prixUnitaire=1500;prixQuest=(prixUnitaire*parseInt($("#quest_52").val()));text='Fourniture de porte extérieure en PVC';prixUnitaire_P=160;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_52").val()));text_P='Pose en rénovation sur bati sain de porte extérieure en PVC'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_46_52").html(text);
					$("#tdUniteQuest_46_52").html('unité');
					$("#tdQteQuest_46_52").html(number_format($("#quest_52").val(),2,'.',''));
					$("#tdPrixUniQuest_46_52").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_46_52").html(number_format(prixQuest,2,'.',''));
					if ( $("#trQuest_46_52_P").size()==0 )
					{
						$("#trQuest_46_52").after('<tr id="trQuest_46_52_P"><td id="tdLabelQuest_46_52_P">'+text_P+'</td><td id="tdUniteQuest_46_52_P">unité</td><td id="tdQteQuest_46_52_P" class="n">'+number_format($("#quest_52").val(),2,'.','')+'</td><td id="tdPrixUniQuest_46_52_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_46_52_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
					else
					{
						$("#tdLabelQuest_46_52_P").html(text_P);
						$("#tdUniteQuest_46_52_P").html('unité');
						$("#tdQteQuest_46_52_P").html(number_format($("#quest_52").val(),2,'.',''));
						$("#tdPrixUniQuest_46_52_P").html(number_format(prixUnitaire_P,2,'.',''));
						$("#tdPrixQuest_46_52_P").html(number_format(prixQuest_P,2,'.',''));
					}
				}
				if ( $("#quest_49").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_2").html(); 
					prixAncienQuest=$("#tdPrixQuest_46_49").html();
					prixAncienQuest_P=$("#tdPrixQuest_46_49_P").html();
					if ( $("#quest_46").val()==54 ) { prixUnitaire=1346.33;prixQuest=(prixUnitaire*parseInt($("#quest_49").val()));text='Fourniture de porte-fenêtre en bois';prixUnitaire_P=250;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_49").val()));text_P='Pose en rénovation sur bati sain de porte fenêtre en bois'; }
					else if ( $("#quest_46").val()==55 ) { prixUnitaire=1279.67;prixQuest=(prixUnitaire*parseInt($("#quest_49").val()));text='Fourniture de porte-fenêtre en ALU';prixUnitaire_P=250;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_49").val()));text_P='Pose en rénovation sur bati sain de porte fenêtre en ALU'; }
					else if ( $("#quest_46").val()==56 ) { prixUnitaire=1010;prixQuest=(prixUnitaire*parseInt($("#quest_49").val()));text='Fourniture de porte-fenêtre en PVC';prixUnitaire_P=250;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_49").val()));text_P='Pose en rénovation sur bati sain de porte fenêtre en PVC'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_46_49").html(text);
					$("#tdUniteQuest_46_49").html('unité');
					$("#tdQteQuest_46_49").html(number_format($("#quest_49").val(),2,'.',''));
					$("#tdPrixUniQuest_46_49").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_46_49").html(number_format(prixQuest,2,'.',''));
					if ( $("#trQuest_46_49_P").size()==0 )
					{
						$("#trQuest_46_49").after('<tr id="trQuest_46_49_P"><td id="tdLabelQuest_46_49_P">'+text_P+'</td><td id="tdUniteQuest_46_49_P">unité</td><td id="tdQteQuest_46_49_P" class="n">'+number_format($("#quest_49").val(),2,'.','')+'</td><td id="tdPrixUniQuest_46_49_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_46_49_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
					else
					{
						$("#tdLabelQuest_46_49_P").html(text_P);
						$("#tdUniteQuest_46_49_P").html('unité');
						$("#tdQteQuest_46_49_P").html(number_format($("#quest_49").val(),2,'.',''));
						$("#tdPrixUniQuest_46_49_P").html(number_format(prixUnitaire_P,2,'.',''));
						$("#tdPrixQuest_46_49_P").html(number_format(prixQuest_P,2,'.',''));
					}
				}
				if ( $("#quest_50").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_2").html(); 
					prixAncienQuest=$("#tdPrixQuest_46_50").html();
					prixAncienQuest_P=$("#tdPrixQuest_46_50_P").html();
					if ( $("#quest_46").val()==54 ) { prixUnitaire=999.48;prixQuest=(prixUnitaire*parseInt($("#quest_50").val()));text='Fourniture de vélux en bois';prixUnitaire_P=250;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_50").val()));text_P='Pose de vélux en bois'; }
					else if ( $("#quest_46").val()==55 ) { prixUnitaire=950;prixQuest=(prixUnitaire*parseInt($("#quest_50").val()));text='Fourniture de vélux en ALU';prixUnitaire_P=250;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_50").val()));text_P='Pose de vélux en ALU'; }
					else if ( $("#quest_46").val()==56 ) { prixUnitaire=950;prixQuest=(prixUnitaire*parseInt($("#quest_50").val()));text='Fourniture de vélux en PVC';prixUnitaire_P=250;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_50").val()));text_P='Pose de vélux en PVC'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_46_50").html(text);
					$("#tdUniteQuest_46_50").html('unité');
					$("#tdQteQuest_46_50").html(number_format($("#quest_50").val(),2,'.',''));
					$("#tdPrixUniQuest_46_50").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_46_50").html(number_format(prixQuest,2,'.',''));
					if ( $("#trQuest_46_50_P").size()==0 )
					{
						$("#trQuest_46_50").after('<tr id="trQuest_46_50_P"><td id="tdLabelQuest_46_50_P">'+text_P+'</td><td id="tdUniteQuest_46_50_P">unité</td><td id="tdQteQuest_46_50_P" class="n">'+number_format($("#quest_50").val(),2,'.','')+'</td><td id="tdPrixUniQuest_46_50_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_46_50_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
					else
					{
						$("#tdLabelQuest_46_50_P").html(text_P);
						$("#tdUniteQuest_46_50_P").html('unité');
						$("#tdQteQuest_46_50_P").html(number_format($("#quest_50").val(),2,'.',''));
						$("#tdPrixUniQuest_46_50_P").html(number_format(prixUnitaire_P,2,'.',''));
						$("#tdPrixQuest_46_50_P").html(number_format(prixQuest_P,2,'.',''));
					}
				}
			}
		}*/
		//Partie Menuiserie --------------- Fenêtre --------------
		else if ( idQ==72 ) 
		{  
			if ( $("#quest_72").val()==0 )
			{
				if ( $("#quest_47").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_72_47").html();
					prixAncienQuest_P=$("#tdPrixQuest_72_47_P").html();
					prixAncienCat=$("#prixCateg_2").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_72_47").html('Donner plus de précisions, en répondant aux questions pour la partie : Fenêtre');
					$("#tdUniteQuest_72_47").html('');
					$("#tdQteQuest_72_47").html('0.00');
					$("#tdPrixUniQuest_72_47").html('0.00');
					$("#tdPrixQuest_72_47").html('0.00');
					$("#trQuest_72_47_P").remove();
				}
			}
			else
			{
				if ( $("#quest_47").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_2").html(); 
					prixAncienQuest=$("#tdPrixQuest_72_47").html();
					prixAncienQuest_P=$("#tdPrixQuest_72_47_P").html();
					if ( $("#quest_72").val()==84 ) { prixUnitaire=646.5;prixQuest=(prixUnitaire*parseInt($("#quest_47").val()));text='Fourniture de petite fenêtre en bois';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_47").val()));text_P='Pose en rénovation sur bati sain de petite fenêtre en bois'; }
					else if ( $("#quest_72").val()==85 ) { prixUnitaire=614.5;prixQuest=(prixUnitaire*parseInt($("#quest_47").val()));text='Fourniture de petite fenêtre en ALU';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_47").val()));text_P='Pose en rénovation sur bati sain de petite fenêtre en ALU'; }
					else if ( $("#quest_72").val()==86 ) { prixUnitaire=485;prixQuest=(prixUnitaire*parseInt($("#quest_47").val()));text='Fourniture de petite fenêtre en PVC';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_47").val()));text_P='Pose en rénovation sur bati sain de petite fenêtre en PVC'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_72_47").html(text);
					$("#tdUniteQuest_72_47").html('unité');
					$("#tdQteQuest_72_47").html(number_format(parseInt($("#quest_47").val()),2,'.',''));
					$("#tdPrixUniQuest_72_47").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_72_47").html(number_format(prixQuest,2,'.',''));
					if ( $("#trQuest_72_47_P").size()==0 )
					{
						$("#trQuest_72_47").after('<tr id="trQuest_72_47_P"><td id="tdLabelQuest_72_47_P">'+text_P+'</td><td id="tdUniteQuest_72_47_P">unité</td><td id="tdQteQuest_72_47_P" class="n">'+number_format(parseInt($("#quest_47").val()),2,'.','')+'</td><td id="tdPrixUniQuest_72_47_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_72_47_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
					else
					{
						$("#tdLabelQuest_72_47_P").html(text_P);
						$("#tdUniteQuest_72_47_P").html('unité');
						$("#tdQteQuest_72_47_P").html(number_format(parseInt($("#quest_47").val()),2,'.',''));
						$("#tdPrixUniQuest_72_47_P").html(number_format(prixUnitaire_P,2,'.',''));
						$("#tdPrixQuest_72_47_P").html(number_format(prixQuest_P,2,'.',''));
					}
				}
			}
		}
		else if ( idQ==47 )
		{
			if ( $("#panier_2").html()=="" )
			{
				if ( $("#quest_47").val() )
				{
					if ( $("#quest_72").val()==0 )
					{
						$("#panier_2").css('display','');
						$("#panier_2").append('<tr id="trCat_2" class="stot"><th colspan="3">Menuiserie</th><th>sous-total HT</th><th id="prixCateg_2" class="n">0</th></tr>');
						$("#panier_2").append('<tr id="trQuest_72_47"><td id="tdLabelQuest_72_47">Donner plus de précisions, en répondant aux questions pour la partie : Fenêtre</td><td id="tdUniteQuest_72_47"></td><td id="tdQteQuest_72_47" class="n">0.00</td><td id="tdPrixUniQuest_72_47" class="n">0.00</td><td id="tdPrixQuest_72_47" class="n">0.00</td></tr>');
					}
					else
					{
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_72").val()==84 ) { prixUnitaire=646.5;prixQuest=(prixUnitaire*parseInt($("#quest_47").val()));text='Fourniture de petite fenêtre en bois';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_47").val()));text_P='Pose en rénovation sur bati sain de petite fenêtre en bois'; }
						else if ( $("#quest_72").val()==85 ) { prixUnitaire=614.5;prixQuest=(prixUnitaire*parseInt($("#quest_47").val()));text='Fourniture de petite fenêtre en ALU';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_47").val()));text_P='Pose en rénovation sur bati sain de petite fenêtre en ALU'; }
						else if ( $("#quest_72").val()==86 ) { prixUnitaire=485;prixQuest=(prixUnitaire*parseInt($("#quest_47").val()));text='Fourniture de petite fenêtre en PVC';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_47").val()));text_P='Pose en rénovation sur bati sain de petite fenêtre en PVC'; }
						prixCat=prixQuest + prixQuest_P;
						totalHT=(totalHTancien*1)+prixQuest+prixQuest_P;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#panier_2").css('display','');
						$("#panier_2").append('<tr id="trCat_2" class="stot"><th colspan="3">Menuiserie</th><th>sous-total HT</th><th id="prixCateg_2" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
						$("#panier_2").append('<tr id="trQuest_72_47"><td id="tdLabelQuest_72_47">'+text+'</td><td id="tdUniteQuest_72_47">unité</td><td id="tdQteQuest_72_47" class="n">'+number_format(parseInt($("#quest_47").val()),2,'.','')+'</td><td id="tdPrixUniQuest_72_47" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_72_47" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
						$("#panier_2").append('<tr id="trQuest_72_47_P"><td id="tdLabelQuest_72_47_P">'+text_P+'</td><td id="tdUniteQuest_72_47_P">unité</td><td id="tdQteQuest_72_47_P" class="n">'+number_format(parseInt($("#quest_47").val()),2,'.','')+'</td><td id="tdPrixUniQuest_72_47_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_72_47_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
				}
			}
			else
			{
				if ( $("#quest_47").val() )
				{
					if ( $("#quest_72").val()!=0 )
					{
						prixAncienCat=$("#prixCateg_2").html(); 
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_72").val()==84 ) { prixUnitaire=646.5;prixQuest=(prixUnitaire*parseInt($("#quest_47").val()));text='Fourniture de petite fenêtre en bois';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_47").val()));text_P='Pose en rénovation sur bati sain de petite fenêtre en bois'; }
						else if ( $("#quest_72").val()==85 ) { prixUnitaire=614.5;prixQuest=(prixUnitaire*parseInt($("#quest_47").val()));text='Fourniture de petite fenêtre en ALU';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_47").val()));text_P='Pose en rénovation sur bati sain de petite fenêtre en ALU'; }
						else if ( $("#quest_72").val()==86 ) { prixUnitaire=485;prixQuest=(prixUnitaire*parseInt($("#quest_47").val()));text='Fourniture de petite fenêtre en PVC';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_47").val()));text_P='Pose en rénovation sur bati sain de petite fenêtre en PVC'; }
						if ( $("#trQuest_72_47").size()==0 )
						{
							prixCat=(prixAncienCat*1) + prixQuest + prixQuest_P;
							totalHT=(totalHTancien*1) + prixQuest + prixQuest_P;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
							$("#panier_2").append('<tr id="trQuest_72_47"><td id="tdLabelQuest_72_47">'+text+'</td><td id="tdUniteQuest_72_47">unité</td><td id="tdQteQuest_72_47" class="n">'+number_format(parseInt($("#quest_47").val()),2,'.','')+'</td><td id="tdPrixUniQuest_72_47" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_72_47" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
							$("#panier_2").append('<tr id="trQuest_72_47_P"><td id="tdLabelQuest_72_47_P">'+text_P+'</td><td id="tdUniteQuest_72_47_P">unité</td><td id="tdQteQuest_72_47_P" class="n">'+number_format(parseInt($("#quest_47").val()),2,'.','')+'</td><td id="tdPrixUniQuest_72_47_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_72_47_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
						}
						else
						{
							prixAncienQuest=$("#tdPrixQuest_72_47").html();
							prixAncienQuest_P=$("#tdPrixQuest_72_47_P").html();
							prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
							totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
							$("#tdQteQuest_72_47").html(number_format(parseInt($("#quest_47").val()),2,'.',''));
							$("#tdPrixQuest_72_47").html(number_format(prixQuest,2,'.',''));
							$("#tdQteQuest_72_47_P").html(number_format(parseInt($("#quest_47").val()),2,'.',''));
							$("#tdPrixQuest_72_47_P").html(number_format(prixQuest_P,2,'.',''));
						}
					}
					else
					{
						if ( $("#trQuest_72_47").size()==0 )
						{
							$("#panier_2").append('<tr id="trQuest_72_47"><td id="tdLabelQuest_72_47">Donner plus de précisions, en répondant aux questions pour la partie : Fenêtre</td><td id="tdUniteQuest_72_47"></td><td id="tdQteQuest_72_47" class="n">0.00</td><td id="tdPrixUniQuest_72_47" class="n">0.00</td><td id="tdPrixQuest_72_47" class="n">0.00</td></tr>');
						}
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_2").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_72_47").html();
					prixAncienQuest_P=$("#tdPrixQuest_72_47_P").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#trQuest_72_47").remove();
					$("#trQuest_72_47_P").remove();
					if ( $("#panier_2").html()=='<tr id="trCat_2" class="stot"><th colspan="3">Menuiserie</th><th>sous-total HT</th><th id="prixCateg_2" class="n">0.00</th></tr>' ) 
						$("#trCat_2").remove();
				}
			}
		}
		/*else if ( idQ==48 )
		{
			if ( $("#panier_2").html()=="" )
			{
				if ( $("#quest_48").val() )
				{
					if ( $("#quest_46").val()==0 )
					{
						$("#panier_2").css('display','');
						$("#panier_2").append('<tr id="trCat_2" class="stot"><th colspan="3">Menuiserie</th><th>sous-total HT</th><th id="prixCateg_2" class="n">0</th></tr>');
						$("#panier_2").append('<tr id="trQuest_46_48"><td id="tdLabelQuest_46_48">Donner plus de précisions, en répondant aux questions pour la partie : Généralités</td><td id="tdUniteQuest_46_48"></td><td id="tdQteQuest_46_48" class="n">0.00</td><td id="tdPrixUniQuest_46_48" class="n">0.00</td><td id="tdPrixQuest_46_48" class="n">0.00</td></tr>');
					}
					else
					{
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_46").val()==54 ) { prixUnitaire=953.1;prixQuest=(prixUnitaire*parseInt($("#quest_48").val()));text='Fourniture de fenêtre de taille standard en bois';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_48").val()));text_P='Pose en rénovation sur bati sain de fenêtre de taille standard en bois'; }
						else if ( $("#quest_46").val()==55 ) { prixUnitaire=905.9;prixQuest=(prixUnitaire*parseInt($("#quest_48").val()));text='Fourniture de fenêtre de taille standard en ALU';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_48").val()));text_P='Pose en rénovation sur bati sain de fenêtre de taille standard en ALU'; }
						else if ( $("#quest_46").val()==56 ) { prixUnitaire=715;prixQuest=(prixUnitaire*parseInt($("#quest_48").val()));text='Fourniture de fenêtre de taille standard en PVC';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_48").val()));text_P='Pose en rénovation sur bati sain de fenêtre de taille standard en PVC'; }
						prixCat=prixQuest + prixQuest_P;
						totalHT=(totalHTancien*1)+prixQuest+prixQuest_P;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#panier_2").css('display','');
						$("#panier_2").append('<tr id="trCat_2" class="stot"><th colspan="3">Menuiserie</th><th>sous-total HT</th><th id="prixCateg_2" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
						$("#panier_2").append('<tr id="trQuest_46_48"><td id="tdLabelQuest_46_48">'+text+'</td><td id="tdUniteQuest_46_48">unité</td><td id="tdQteQuest_46_48" class="n">'+number_format(parseInt($("#quest_48").val()),2,'.','')+'</td><td id="tdPrixUniQuest_46_48" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_46_48" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
						$("#panier_2").append('<tr id="trQuest_46_48_P"><td id="tdLabelQuest_46_48_P">'+text_P+'</td><td id="tdUniteQuest_46_48_P">unité</td><td id="tdQteQuest_46_48_P" class="n">'+number_format(parseInt($("#quest_48").val()),2,'.','')+'</td><td id="tdPrixUniQuest_46_48_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_46_48_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
				}
			}
			else
			{
				if ( $("#quest_48").val() )
				{
					if ( $("#quest_46").val()!=0 )
					{
						prixAncienCat=$("#prixCateg_2").html(); 
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_46").val()==54 ) { prixUnitaire=953.1;prixQuest=(prixUnitaire*parseInt($("#quest_48").val()));text='Fourniture de fenêtre de taille standard en bois';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_48").val()));text_P='Pose en rénovation sur bati sain de fenêtre de taille standard en bois'; }
						else if ( $("#quest_46").val()==55 ) { prixUnitaire=905.9;prixQuest=(prixUnitaire*parseInt($("#quest_48").val()));text='Fourniture de fenêtre de taille standard en ALU';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_48").val()));text_P='Pose en rénovation sur bati sain de fenêtre de taille standard en ALU'; }
						else if ( $("#quest_46").val()==56 ) { prixUnitaire=715;prixQuest=(prixUnitaire*parseInt($("#quest_48").val()));text='Fourniture de fenêtre de taille standard en PVC';prixUnitaire_P=135;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_48").val()));text_P='Pose en rénovation sur bati sain de fenêtre de taille standard en PVC'; }
						if ( $("#trQuest_46_48").size()==0 )
						{
							prixCat=(prixAncienCat*1) + prixQuest + prixQuest_P;
							totalHT=(totalHTancien*1) + prixQuest + prixQuest_P;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
							$("#panier_2").append('<tr id="trQuest_46_48"><td id="tdLabelQuest_46_48">'+text+'</td><td id="tdUniteQuest_46_48">unité</td><td id="tdQteQuest_46_48" class="n">'+number_format(parseInt($("#quest_48").val()),2,'.','')+'</td><td id="tdPrixUniQuest_46_48" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_46_48" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
							$("#panier_2").append('<tr id="trQuest_46_48_P"><td id="tdLabelQuest_46_48_P">'+text_P+'</td><td id="tdUniteQuest_46_48_P">unité</td><td id="tdQteQuest_46_48_P" class="n">'+number_format(parseInt($("#quest_48").val()),2,'.','')+'</td><td id="tdPrixUniQuest_46_48_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_46_48_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
						}
						else
						{
							prixAncienQuest=$("#tdPrixQuest_46_48").html();
							prixAncienQuest_P=$("#tdPrixQuest_46_48_P").html();
							prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
							totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
							$("#tdQteQuest_46_48").html(number_format(parseInt($("#quest_48").val()),2,'.',''));
							$("#tdPrixQuest_46_48").html(number_format(prixQuest,2,'.',''));
							$("#tdQteQuest_46_48_P").html(number_format(parseInt($("#quest_48").val()),2,'.',''));
							$("#tdPrixQuest_46_48_P").html(number_format(prixQuest_P,2,'.',''));
						}
					}
					else
					{
						if ( $("#trQuest_46_48").size()==0 )
						{
							$("#panier_2").append('<tr id="trQuest_46_48"><td id="tdLabelQuest_46_48">Donner plus de précisions, en répondant aux questions pour la partie : Généralités</td><td id="tdUniteQuest_46_48"></td><td id="tdQteQuest_46_48" class="n">0.00</td><td id="tdPrixUniQuest_46_48" class="n">0.00</td><td id="tdPrixQuest_46_48" class="n">0.00</td></tr>');
						}
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_2").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_46_48").html();
					prixAncienQuest_P=$("#tdPrixQuest_46_48_P").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#trQuest_46_48").remove();
					$("#trQuest_46_48_P").remove();
					if ( $("#panier_2").html()=='<tr id="trCat_2" class="stot"><th colspan="3">Menuiserie</th><th>sous-total HT</th><th id="prixCateg_2" class="n">0.00</th></tr>' ) 
						$("#trCat_2").remove();
				}
			}
		}*/
		//Partie Menuiserie --------------- Porte --------------
		else if ( idQ==71 ) 
		{  
			if ( $("#quest_71").val()==0 )
			{
				if ( $("#quest_51").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_71_51").html();
					prixAncienQuest_P=$("#tdPrixQuest_71_51_P").html();
					prixAncienCat=$("#prixCateg_2").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_71_51").html('Donner plus de précisions, en répondant aux questions pour la partie : Porte');
					$("#tdUniteQuest_71_51").html('');
					$("#tdQteQuest_71_51").html('0.00');
					$("#tdPrixUniQuest_71_51").html('0.00');
					$("#tdPrixQuest_71_51").html('0.00');
					$("#trQuest_71_51_P").remove();
				}
			}
			else
			{
				if ( $("#quest_51").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_2").html(); 
					prixAncienQuest=$("#tdPrixQuest_71_51").html();
					prixAncienQuest_P=$("#tdPrixQuest_71_51_P").html();
					if ( $("#quest_71").val()==81 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_51").val()));text='Fourniture de bloc porte intérieur en bois ';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_51").val()));text_P='Pose en rénovation sur bati sain de bloc porte en bois'; }
					else if ( $("#quest_71").val()==82 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_51").val()));text='Fourniture de bloc porte intérieur en ALU';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_51").val()));text_P='Pose en rénovation sur bati sain de bloc porte en ALU'; }
					else if ( $("#quest_71").val()==83 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_51").val()));text='Fourniture de bloc porte intérieur en PVC';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_51").val()));text_P='Pose en rénovation sur bati sain de bloc porte en PVC'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_71_51").html(text);
					$("#tdUniteQuest_71_51").html('unité');
					$("#tdQteQuest_71_51").html(number_format(parseInt($("#quest_47").val()),2,'.',''));
					$("#tdPrixUniQuest_71_51").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_71_51").html(number_format(prixQuest,2,'.',''));
					if ( $("#trQuest_71_51_P").size()==0 )
					{
						$("#trQuest_71_51").after('<tr id="trQuest_71_51_P"><td id="tdLabelQuest_71_51_P">'+text_P+'</td><td id="tdUniteQuest_71_51_P">unité</td><td id="tdQteQuest_71_51_P" class="n">'+number_format($("#quest_51").val(),2,'.','')+'</td><td id="tdPrixUniQuest_71_51_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_71_51_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
					else
					{
						$("#tdLabelQuest_71_51_P").html(text_P);
						$("#tdUniteQuest_71_51_P").html('unité');
						$("#tdQteQuest_71_51_P").html(number_format($("#quest_51").val(),2,'.',''));
						$("#tdPrixUniQuest_71_51_P").html(number_format(prixUnitaire_P,2,'.',''));
						$("#tdPrixQuest_71_51_P").html(number_format(prixQuest_P,2,'.',''));
					}
				}
			}
		}
		else if ( idQ==51 )
		{
			if ( $("#panier_2").html()=="" )
			{
				if ( $("#quest_51").val() )
				{
					if ( $("#quest_71").val()==0 )
					{
						$("#panier_2").css('display','');
						$("#panier_2").append('<tr id="trCat_2" class="stot"><th colspan="3">Menuiserie</th><th>sous-total HT</th><th id="prixCateg_2" class="n">0</th></tr>');
						$("#panier_2").append('<tr id="trQuest_71_51"><td id="tdLabelQuest_71_51">Donner plus de précisions, en répondant aux questions pour la partie : Porte</td><td id="tdUniteQuest_71_51"></td><td id="tdQteQuest_71_51" class="n">0.00</td><td id="tdPrixUniQuest_71_51" class="n">0.00</td><td id="tdPrixQuest_71_51" class="n">0.00</td></tr>');
					}
					else
					{
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_71").val()==81 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_51").val()));text='Fourniture de bloc porte intérieur en bois ';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_51").val()));text_P='Pose en rénovation sur bati sain de bloc porte en bois'; }
						else if ( $("#quest_71").val()==82 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_51").val()));text='Fourniture de bloc porte intérieur en ALU';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_51").val()));text_P='Pose en rénovation sur bati sain de bloc porte en ALU'; }
						else if ( $("#quest_71").val()==83 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_51").val()));text='Fourniture de bloc porte intérieur en PVC';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_51").val()));text_P='Pose en rénovation sur bati sain de bloc porte en PVC'; }
						prixCat=prixQuest + prixQuest_P;
						totalHT=(totalHTancien*1)+prixQuest+prixQuest_P;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#panier_2").css('display','');
						$("#panier_2").append('<tr id="trCat_2" class="stot"><th colspan="3">Menuiserie</th><th>sous-total HT</th><th id="prixCateg_2" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
						$("#panier_2").append('<tr id="trQuest_71_51"><td id="tdLabelQuest_71_51">'+text+'</td><td id="tdUniteQuest_71_51">unité</td><td id="tdQteQuest_71_51" class="n">'+number_format(parseInt($("#quest_51").val()),2,'.','')+'</td><td id="tdPrixUniQuest_71_51" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_71_51" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
						$("#panier_2").append('<tr id="trQuest_71_51_P"><td id="tdLabelQuest_71_51_P">'+text_P+'</td><td id="tdUniteQuest_71_51_P">unité</td><td id="tdQteQuest_71_51_P" class="n">'+number_format(parseInt($("#quest_51").val()),2,'.','')+'</td><td id="tdPrixUniQuest_71_51_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_71_51_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
				}
			}
			else
			{
				if ( $("#quest_51").val() )
				{
					if ( $("#quest_71").val()!=0 )
					{
						prixAncienCat=$("#prixCateg_2").html(); 
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_71").val()==81 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_51").val()));text='Fourniture de bloc porte intérieur en bois ';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_51").val()));text_P='Pose en rénovation sur bati sain de bloc porte en bois'; }
						else if ( $("#quest_71").val()==82 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_51").val()));text='Fourniture de bloc porte intérieur en ALU';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_51").val()));text_P='Pose en rénovation sur bati sain de bloc porte en ALU'; }
						else if ( $("#quest_71").val()==83 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_51").val()));text='Fourniture de bloc porte intérieur en PVC';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_51").val()));text_P='Pose en rénovation sur bati sain de bloc porte en PVC'; }
						if ( $("#trQuest_71_51").size()==0 )
						{
							prixCat=(prixAncienCat*1) + prixQuest + prixQuest_P;
							totalHT=(totalHTancien*1) + prixQuest + prixQuest_P;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
							$("#panier_2").append('<tr id="trQuest_71_51"><td id="tdLabelQuest_71_51">'+text+'</td><td id="tdUniteQuest_71_51">unité</td><td id="tdQteQuest_71_51" class="n">'+number_format(parseInt($("#quest_51").val()),2,'.','')+'</td><td id="tdPrixUniQuest_71_51" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_71_51" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
							$("#panier_2").append('<tr id="trQuest_71_51_P"><td id="tdLabelQuest_71_51_P">'+text_P+'</td><td id="tdUniteQuest_71_51_P">unité</td><td id="tdQteQuest_71_51_P" class="n">'+number_format(parseInt($("#quest_51").val()),2,'.','')+'</td><td id="tdPrixUniQuest_71_51_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_71_51_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
						}
						else
						{
							prixAncienQuest=$("#tdPrixQuest_71_51").html();
							prixAncienQuest_P=$("#tdPrixQuest_71_51_P").html();
							prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
							totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
							$("#tdQteQuest_71_51").html(number_format(parseInt($("#quest_51").val()),2,'.',''));
							$("#tdPrixQuest_71_51").html(number_format(prixQuest,2,'.',''));
							$("#tdQteQuest_71_51_P").html(number_format(parseInt($("#quest_51").val()),2,'.',''));
							$("#tdPrixQuest_71_51_P").html(number_format(prixQuest_P,2,'.',''));
						}
					}
					else
					{
						if ( $("#trQuest_71_51").size()==0 )
						{
							$("#panier_2").append('<tr id="trQuest_71_51"><td id="tdLabelQuest_71_51">Donner plus de précisions, en répondant aux questions pour la partie : Porte</td><td id="tdUniteQuest_71_51"></td><td id="tdQteQuest_71_51" class="n">0.00</td><td id="tdPrixUniQuest_71_51" class="n">0.00</td><td id="tdPrixQuest_71_51" class="n">0.00</td></tr>');
						}
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_2").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_71_51").html();
					prixAncienQuest_P=$("#tdPrixQuest_71_51_P").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#trQuest_71_51").remove();
					$("#trQuest_71_51_P").remove();
					if ( $("#panier_2").html()=='<tr id="trCat_2" class="stot"><th colspan="3">Menuiserie</th><th>sous-total HT</th><th id="prixCateg_2" class="n">0.00</th></tr>' ) 
						$("#trCat_2").remove();
				}
			}
		}
		else if ( idQ==86 ) 
		{  
			if ( $("#quest_86").val()==0 )
			{
				if ( $("#quest_52").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_86_52").html();
					prixAncienQuest_P=$("#tdPrixQuest_86_52_P").html();
					prixAncienCat=$("#prixCateg_2").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_86_52").html('Donner plus de précisions, en répondant aux questions pour la partie : Porte');
					$("#tdUniteQuest_86_52").html('');
					$("#tdQteQuest_86_52").html('0.00');
					$("#tdPrixUniQuest_86_52").html('0.00');
					$("#tdPrixQuest_86_52").html('0.00');
					$("#trQuest_86_52_P").remove();
				}
			}
			else
			{
				if ( $("#quest_52").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_2").html(); 
					prixAncienQuest=$("#tdPrixQuest_86_52").html();
					prixAncienQuest_P=$("#tdPrixQuest_86_52_P").html();
					if ( $("#quest_86").val()==117 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_52").val()));text='Fourniture de porte extérieure en bois ';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_52").val()));text_P='Pose en rénovation sur bati sain de bloc porte en bois'; }
					else if ( $("#quest_86").val()==118 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_52").val()));text='Fourniture de porte extérieure en ALU';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_52").val()));text_P='Pose en rénovation sur bati sain de bloc porte en ALU'; }
					else if ( $("#quest_86").val()==119 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_52").val()));text='Fourniture de porte extérieure en PVC';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_52").val()));text_P='Pose en rénovation sur bati sain de bloc porte en PVC'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_86_52").html(text);
					$("#tdUniteQuest_86_52").html('unité');
					$("#tdQteQuest_86_52").html(number_format(parseInt($("#quest_52").val()),2,'.',''));
					$("#tdPrixUniQuest_86_52").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_86_52").html(number_format(prixQuest,2,'.',''));
					if ( $("#trQuest_86_52_P").size()==0 )
					{
						$("#trQuest_86_52").after('<tr id="trQuest_86_52_P"><td id="tdLabelQuest_86_52_P">'+text_P+'</td><td id="tdUniteQuest_86_52_P">unité</td><td id="tdQteQuest_86_52_P" class="n">'+number_format($("#quest_52").val(),2,'.','')+'</td><td id="tdPrixUniQuest_86_52_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_86_52_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
					else
					{
						$("#tdLabelQuest_86_52_P").html(text_P);
						$("#tdUniteQuest_86_52_P").html('unité');
						$("#tdQteQuest_86_52_P").html(number_format($("#quest_52").val(),2,'.',''));
						$("#tdPrixUniQuest_86_52_P").html(number_format(prixUnitaire_P,2,'.',''));
						$("#tdPrixQuest_86_52_P").html(number_format(prixQuest_P,2,'.',''));
					}
				}
			}
		}
		else if ( idQ==52 )
		{
			if ( $("#panier_2").html()=="" )
			{
				if ( $("#quest_52").val() )
				{
					if ( $("#quest_86").val()==0 )
					{
						$("#panier_2").css('display','');
						$("#panier_2").append('<tr id="trCat_2" class="stot"><th colspan="3">Menuiserie</th><th>sous-total HT</th><th id="prixCateg_2" class="n">0</th></tr>');
						$("#panier_2").append('<tr id="trQuest_86_52"><td id="tdLabelQuest_86_52">Donner plus de précisions, en répondant aux questions pour la partie : Porte</td><td id="tdUniteQuest_86_52"></td><td id="tdQteQuest_86_52" class="n">0.00</td><td id="tdPrixUniQuest_86_52" class="n">0.00</td><td id="tdPrixQuest_86_52" class="n">0.00</td></tr>');
					}
					else
					{
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_86").val()==117 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_52").val()));text='Fourniture de porte extérieure en bois ';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_52").val()));text_P='Pose en rénovation sur bati sain de bloc porte en bois'; }
						else if ( $("#quest_86").val()==118 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_52").val()));text='Fourniture de porte extérieure en ALU';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_52").val()));text_P='Pose en rénovation sur bati sain de bloc porte en ALU'; }
						else if ( $("#quest_86").val()==119 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_52").val()));text='Fourniture de porte extérieure en PVC';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_52").val()));text_P='Pose en rénovation sur bati sain de bloc porte en PVC'; }
						prixCat=prixQuest + prixQuest_P;
						totalHT=(totalHTancien*1)+prixQuest+prixQuest_P;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#panier_2").css('display','');
						$("#panier_2").append('<tr id="trCat_2" class="stot"><th colspan="3">Menuiserie</th><th>sous-total HT</th><th id="prixCateg_2" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
						$("#panier_2").append('<tr id="trQuest_86_52"><td id="tdLabelQuest_86_52">'+text+'</td><td id="tdUniteQuest_86_52">unité</td><td id="tdQteQuest_86_52" class="n">'+number_format(parseInt($("#quest_52").val()),2,'.','')+'</td><td id="tdPrixUniQuest_86_52" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_86_52" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
						$("#panier_2").append('<tr id="trQuest_86_52_P"><td id="tdLabelQuest_86_52_P">'+text_P+'</td><td id="tdUniteQuest_86_52_P">unité</td><td id="tdQteQuest_86_52_P" class="n">'+number_format(parseInt($("#quest_52").val()),2,'.','')+'</td><td id="tdPrixUniQuest_86_52_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_86_52_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
				}
			}
			else
			{
				if ( $("#quest_52").val() )
				{
					if ( $("#quest_86").val()!=0 )
					{
						prixAncienCat=$("#prixCateg_2").html(); 
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_86").val()==117 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_52").val()));text='Fourniture de porte extérieure en bois ';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_52").val()));text_P='Pose en rénovation sur bati sain de bloc porte en bois'; }
						else if ( $("#quest_86").val()==118 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_52").val()));text='Fourniture de porte extérieure en ALU';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_52").val()));text_P='Pose en rénovation sur bati sain de bloc porte en ALU'; }
						else if ( $("#quest_86").val()==119 ) { prixUnitaire=170;prixQuest=(prixUnitaire*parseInt($("#quest_52").val()));text='Fourniture de porte extérieure en PVC';prixUnitaire_P=120;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_52").val()));text_P='Pose en rénovation sur bati sain de bloc porte en PVC'; }
						if ( $("#trQuest_86_52").size()==0 )
						{
							prixCat=(prixAncienCat*1) + prixQuest + prixQuest_P;
							totalHT=(totalHTancien*1) + prixQuest + prixQuest_P;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
							$("#panier_2").append('<tr id="trQuest_86_52"><td id="tdLabelQuest_86_52">'+text+'</td><td id="tdUniteQuest_86_52">unité</td><td id="tdQteQuest_86_52" class="n">'+number_format(parseInt($("#quest_52").val()),2,'.','')+'</td><td id="tdPrixUniQuest_86_52" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_86_52" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
							$("#panier_2").append('<tr id="trQuest_86_52_P"><td id="tdLabelQuest_86_52_P">'+text_P+'</td><td id="tdUniteQuest_86_52_P">unité</td><td id="tdQteQuest_86_52_P" class="n">'+number_format(parseInt($("#quest_52").val()),2,'.','')+'</td><td id="tdPrixUniQuest_86_52_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_86_52_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
						}
						else
						{
							prixAncienQuest=$("#tdPrixQuest_86_52").html();
							prixAncienQuest_P=$("#tdPrixQuest_86_52_P").html();
							prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
							totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
							$("#tdQteQuest_86_52").html(number_format(parseInt($("#quest_52").val()),2,'.',''));
							$("#tdPrixQuest_86_52").html(number_format(prixQuest,2,'.',''));
							$("#tdQteQuest_86_52_P").html(number_format(parseInt($("#quest_52").val()),2,'.',''));
							$("#tdPrixQuest_86_52_P").html(number_format(prixQuest_P,2,'.',''));
						}
					}
					else
					{
						if ( $("#trQuest_86_52").size()==0 )
						{
							$("#panier_2").append('<tr id="trQuest_86_52"><td id="tdLabelQuest_86_52">Donner plus de précisions, en répondant aux questions pour la partie : Porte</td><td id="tdUniteQuest_86_52"></td><td id="tdQteQuest_86_52" class="n">0.00</td><td id="tdPrixUniQuest_86_52" class="n">0.00</td><td id="tdPrixQuest_86_52" class="n">0.00</td></tr>');
						}
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_2").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_86_52").html();
					prixAncienQuest_P=$("#tdPrixQuest_86_52_P").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#trQuest_86_52").remove();
					$("#trQuest_86_52_P").remove();
					if ( $("#panier_2").html()=='<tr id="trCat_2" class="stot"><th colspan="3">Menuiserie</th><th>sous-total HT</th><th id="prixCateg_2" class="n">0.00</th></tr>' ) 
						$("#trCat_2").remove();
				}
			}
		}
		//Partie Menuiserie --------------- Porte-fenêtre --------------
		else if ( idQ==70 ) 
		{  
			if ( $("#quest_70").val()==0 )
			{
				if ( $("#quest_49").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_70_49").html();
					prixAncienQuest_P=$("#tdPrixQuest_70_49_P").html();
					prixAncienCat=$("#prixCateg_2").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_70_49").html('Donner plus de précisions, en répondant aux questions pour la partie : Porte-fenêtre');
					$("#tdUniteQuest_70_49").html('');
					$("#tdQteQuest_70_49").html('0.00');
					$("#tdPrixUniQuest_70_49").html('0.00');
					$("#tdPrixQuest_70_49").html('0.00');
					$("#trQuest_70_49_P").remove();
				}
			}
			else
			{
				if ( $("#quest_49").val() )
				{
					totalHTancien=$("#totalHT").html();
					prixAncienCat=$("#prixCateg_2").html(); 
					prixAncienQuest=$("#tdPrixQuest_70_49").html();
					prixAncienQuest_P=$("#tdPrixQuest_70_49_P").html();
					if ( $("#quest_70").val()==78 ) { prixUnitaire=1346.33;prixQuest=(prixUnitaire*parseInt($("#quest_49").val()));text='Fourniture de porte-fenêtre en bois';prixUnitaire_P=250;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_49").val()));text_P='Pose en rénovation sur bati sain de porte fenêtre en bois'; }
					else if ( $("#quest_70").val()==79 ) { prixUnitaire=1279.67;prixQuest=(prixUnitaire*parseInt($("#quest_49").val()));text='Fourniture de porte-fenêtre en ALU';prixUnitaire_P=250;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_49").val()));text_P='Pose en rénovation sur bati sain de porte fenêtre en ALU'; }
					else if ( $("#quest_70").val()==80 ) { prixUnitaire=1010;prixQuest=(prixUnitaire*parseInt($("#quest_49").val()));text='Fourniture de porte-fenêtre en PVC';prixUnitaire_P=250;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_49").val()));text_P='Pose en rénovation sur bati sain de porte fenêtre en PVC'; }
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#tdLabelQuest_70_49").html(text);
					$("#tdUniteQuest_70_49").html('unité');
					$("#tdQteQuest_70_49").html(number_format($("#quest_49").val(),2,'.',''));
					$("#tdPrixUniQuest_70_49").html(number_format(prixUnitaire,2,'.',''));
					$("#tdPrixQuest_70_49").html(number_format(prixQuest,2,'.',''));
					if ( $("#trQuest_70_49_P").size()==0 )
					{
						$("#trQuest_70_49").after('<tr id="trQuest_70_49_P"><td id="tdLabelQuest_70_49_P">'+text_P+'</td><td id="tdUniteQuest_70_49_P">unité</td><td id="tdQteQuest_70_49_P" class="n">'+number_format($("#quest_49").val(),2,'.','')+'</td><td id="tdPrixUniQuest_70_49_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_70_49_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
					else
					{
						$("#tdLabelQuest_70_49_P").html(text_P);
						$("#tdUniteQuest_70_49_P").html('unité');
						$("#tdQteQuest_70_49_P").html(number_format($("#quest_49").val(),2,'.',''));
						$("#tdPrixUniQuest_70_49_P").html(number_format(prixUnitaire_P,2,'.',''));
						$("#tdPrixQuest_70_49_P").html(number_format(prixQuest_P,2,'.',''));
					}
				}
			}
		}
		else if ( idQ==49 )
		{
			if ( $("#panier_2").html()=="" )
			{
				if ( $("#quest_49").val() )
				{
					if ( $("#quest_70").val()==0 )
					{
						$("#panier_2").css('display','');
						$("#panier_2").append('<tr id="trCat_2" class="stot"><th colspan="3">Menuiserie</th><th>sous-total HT</th><th id="prixCateg_2" class="n">0</th></tr>');
						$("#panier_2").append('<tr id="trQuest_70_49"><td id="tdLabelQuest_70_49">Donner plus de précisions, en répondant aux questions pour la partie : Porte-fenêtre</td><td id="tdUniteQuest_70_49"></td><td id="tdQteQuest_70_49" class="n">0.00</td><td id="tdPrixUniQuest_70_49" class="n">0.00</td><td id="tdPrixQuest_70_49" class="n">0.00</td></tr>');
					}
					else
					{
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_70").val()==78 ) { prixUnitaire=1346.33;prixQuest=(prixUnitaire*parseInt($("#quest_49").val()));text='Fourniture de porte-fenêtre en bois';prixUnitaire_P=250;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_49").val()));text_P='Pose en rénovation sur bati sain de porte fenêtre en bois'; }
						else if ( $("#quest_70").val()==79 ) { prixUnitaire=1279.67;prixQuest=(prixUnitaire*parseInt($("#quest_49").val()));text='Fourniture de porte-fenêtre en ALU';prixUnitaire_P=250;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_49").val()));text_P='Pose en rénovation sur bati sain de porte fenêtre en ALU'; }
						else if ( $("#quest_70").val()==80 ) { prixUnitaire=1010;prixQuest=(prixUnitaire*parseInt($("#quest_49").val()));text='Fourniture de porte-fenêtre en PVC';prixUnitaire_P=250;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_49").val()));text_P='Pose en rénovation sur bati sain de porte fenêtre en PVC'; }
						prixCat=prixQuest + prixQuest_P;
						totalHT=(totalHTancien*1)+prixQuest+prixQuest_P;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#panier_2").css('display','');
						$("#panier_2").append('<tr id="trCat_2" class="stot"><th colspan="3">Menuiserie</th><th>sous-total HT</th><th id="prixCateg_2" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
						$("#panier_2").append('<tr id="trQuest_70_49"><td id="tdLabelQuest_70_49">'+text+'</td><td id="tdUniteQuest_70_49">unité</td><td id="tdQteQuest_70_49" class="n">'+number_format(parseInt($("#quest_49").val()),2,'.','')+'</td><td id="tdPrixUniQuest_70_49" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_70_49" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
						$("#panier_2").append('<tr id="trQuest_70_49_P"><td id="tdLabelQuest_70_49_P">'+text_P+'</td><td id="tdUniteQuest_70_49_P">unité</td><td id="tdQteQuest_70_49_P" class="n">'+number_format(parseInt($("#quest_49").val()),2,'.','')+'</td><td id="tdPrixUniQuest_70_49_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_70_49_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
				}
			}
			else
			{
				if ( $("#quest_49").val() )
				{
					if ( $("#quest_70").val()!=0 )
					{
						prixAncienCat=$("#prixCateg_2").html(); 
						totalHTancien=$("#totalHT").html();
						if ( $("#quest_70").val()==78 ) { prixUnitaire=1346.33;prixQuest=(prixUnitaire*parseInt($("#quest_49").val()));text='Fourniture de porte-fenêtre en bois';prixUnitaire_P=250;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_49").val()));text_P='Pose en rénovation sur bati sain de porte fenêtre en bois'; }
						else if ( $("#quest_70").val()==79 ) { prixUnitaire=1279.67;prixQuest=(prixUnitaire*parseInt($("#quest_49").val()));text='Fourniture de porte-fenêtre en ALU';prixUnitaire_P=250;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_49").val()));text_P='Pose en rénovation sur bati sain de porte fenêtre en ALU'; }
						else if ( $("#quest_70").val()==80 ) { prixUnitaire=1010;prixQuest=(prixUnitaire*parseInt($("#quest_49").val()));text='Fourniture de porte-fenêtre en PVC';prixUnitaire_P=250;prixQuest_P=(prixUnitaire_P*parseInt($("#quest_49").val()));text_P='Pose en rénovation sur bati sain de porte fenêtre en PVC'; }
						if ( $("#trQuest_70_49").size()==0 )
						{
							prixCat=(prixAncienCat*1) + prixQuest + prixQuest_P;
							totalHT=(totalHTancien*1) + prixQuest + prixQuest_P;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
							$("#panier_2").append('<tr id="trQuest_70_49"><td id="tdLabelQuest_70_49">'+text+'</td><td id="tdUniteQuest_70_49">unité</td><td id="tdQteQuest_70_49" class="n">'+number_format(parseInt($("#quest_49").val()),2,'.','')+'</td><td id="tdPrixUniQuest_70_49" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_70_49" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
							$("#panier_2").append('<tr id="trQuest_70_49_P"><td id="tdLabelQuest_70_49_P">'+text_P+'</td><td id="tdUniteQuest_70_49_P">unité</td><td id="tdQteQuest_70_49_P" class="n">'+number_format(parseInt($("#quest_49").val()),2,'.','')+'</td><td id="tdPrixUniQuest_70_49_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_70_49_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
						}
						else
						{
							prixAncienQuest=$("#tdPrixQuest_70_49").html();
							prixAncienQuest_P=$("#tdPrixQuest_70_49_P").html();
							prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
							totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1) + prixQuest + prixQuest_P;
							totalTVA=totalHT*19.6/100;
							totalTTC=totalHT+totalTVA;
							$("#totalHT").html(number_format(totalHT,2,'.',''));
							$("#totalTVA").html(number_format(totalTVA,2,'.',''));
							$("#totalTTC").html(number_format(totalTTC,2,'.',''));
							$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
							$("#tdQteQuest_70_49").html(number_format(parseInt($("#quest_49").val()),2,'.',''));
							$("#tdPrixQuest_70_49").html(number_format(prixQuest,2,'.',''));
							$("#tdQteQuest_70_49_P").html(number_format(parseInt($("#quest_49").val()),2,'.',''));
							$("#tdPrixQuest_70_49_P").html(number_format(prixQuest_P,2,'.',''));
						}
					}
					else
					{
						if ( $("#trQuest_70_49").size()==0 )
						{
							$("#panier_2").append('<tr id="trQuest_70_49"><td id="tdLabelQuest_70_49">Donner plus de précisions, en répondant aux questions pour la partie : Porte-fenêtre</td><td id="tdUniteQuest_70_49"></td><td id="tdQteQuest_70_49" class="n">0.00</td><td id="tdPrixUniQuest_70_49" class="n">0.00</td><td id="tdPrixQuest_70_49" class="n">0.00</td></tr>');
						}
					}
				}
				else
				{
					prixAncienCat=$("#prixCateg_2").html();
					totalHTancien=$("#totalHT").html();
					prixAncienQuest=$("#tdPrixQuest_70_49").html();
					prixAncienQuest_P=$("#tdPrixQuest_70_49_P").html();
					prixCat=(prixAncienCat*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalHT=(totalHTancien*1) - (prixAncienQuest*1) - (prixAncienQuest_P*1);
					totalTVA=totalHT*19.6/100;
					totalTTC=totalHT+totalTVA;
					$("#totalHT").html(number_format(totalHT,2,'.',''));
					$("#totalTVA").html(number_format(totalTVA,2,'.',''));
					$("#totalTTC").html(number_format(totalTTC,2,'.',''));
					$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
					$("#trQuest_70_49").remove();
					$("#trQuest_70_49_P").remove();
					if ( $("#panier_2").html()=='<tr id="trCat_2" class="stot"><th colspan="3">Menuiserie</th><th>sous-total HT</th><th id="prixCateg_2" class="n">0.00</th></tr>' ) 
						$("#trCat_2").remove();
				}
			}
		}
		//Partie Menuiserie --------------- Escalier --------------
		else if ( idQ==54 )
		{
			if ( $("#panier_2").html()=="" )
			{
				totalHTancien=$("#totalHT").html();
				if ( $("#quest_54").val()==57 ) { prixUnitaire=350;prixQuest=(prixUnitaire*1);text='Pose simple d\'escalier sans reprise de maçonnerie avec trémie existante';prixUnitaire_P=400;prixQuest_P=(prixUnitaire_P*1);text_P='Fourniture d\'escalier standard simple en sapin'; }
				else if ( $("#quest_54").val()==58 ) { prixUnitaire=350;prixQuest=(prixUnitaire*1);text='Pose simple d\'escalier sans reprise de maçonnerie avec trémie existante';prixUnitaire_P=1250;prixQuest_P=(prixUnitaire_P*1);text_P='Fourniture d\'escalier quart standard en chêne'; }
				else if ( $("#quest_54").val()==59 ) { prixUnitaire=350;prixQuest=(prixUnitaire*1);text='Pose simple d\'escalier sans reprise de maçonnerie avec trémie existante';prixUnitaire_P=2000;prixQuest_P=(prixUnitaire_P*1);text_P='Fourniture d\'escalier quart standard en métal'; }
				else if ( $("#quest_54").val()==60 ) { prixUnitaire=350;prixQuest=(prixUnitaire*1);text='Pose simple d\'escalier sans reprise de maçonnerie avec trémie existante';prixUnitaire_P=4500;prixQuest_P=(prixUnitaire_P*1);text_P='Fourniture d\'escalier sur mesure en bois, métal ou béton'; }
				prixCat=prixQuest+prixQuest_P;
				totalHT=(totalHTancien*1)+prixQuest+prixQuest_P;
				totalTVA=totalHT*19.6/100;
				totalTTC=totalHT+totalTVA;
				$("#totalHT").html(number_format(totalHT,2,'.',''));
				$("#totalTVA").html(number_format(totalTVA,2,'.',''));
				$("#totalTTC").html(number_format(totalTTC,2,'.',''));
				$("#panier_2").css('display','');
				$("#panier_2").append('<tr id="trCat_2" class="stot"><th colspan="3">Menuiserie</th><th>sous-total HT</th><th id="prixCateg_2" class="n">'+number_format(prixCat,2,'.','')+'</th></tr>');
				$("#panier_2").append('<tr id="trQuest_54"><td id="tdLabelQuest_54">'+text+'</td><td id="tdUniteQuest_54">unité</td><td id="tdQteQuest_54" class="n">1.00</td><td id="tdPrixUniQuest_54" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_54" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
				$("#panier_2").append('<tr id="trQuest_54_P"><td id="tdLabelQuest_54_P">'+text_P+'</td><td id="tdUniteQuest_54_P">unité</td><td id="tdQteQuest_54_P" class="n">1.00</td><td id="tdPrixUniQuest_54_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_54_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
			}
			else
			{
				if ( $("#quest_54").val()!=0 )
				{
					prixAncienCat=$("#prixCateg_2").html(); 
					totalHTancien=$("#totalHT").html();
					if ( $("#quest_54").val()==57 ) { prixUnitaire=350;prixQuest=(prixUnitaire*1);text='Pose simple d\'escalier sans reprise de maçonnerie avec trémie existante';prixUnitaire_P=400;prixQuest_P=(prixUnitaire_P*1);text_P='Fourniture d\'escalier standard simple en sapin'; }
					else if ( $("#quest_54").val()==58 ) { prixUnitaire=350;prixQuest=(prixUnitaire*1);text='Pose simple d\'escalier sans reprise de maçonnerie avec trémie existante';prixUnitaire_P=1250;prixQuest_P=(prixUnitaire_P*1);text_P='Fourniture d\'escalier quart standard en chêne'; }
					else if ( $("#quest_54").val()==59 ) { prixUnitaire=350;prixQuest=(prixUnitaire*1);text='Pose simple d\'escalier sans reprise de maçonnerie avec trémie existante';prixUnitaire_P=2000;prixQuest_P=(prixUnitaire_P*1);text_P='Fourniture d\'escalier quart standard en métal'; }
					else if ( $("#quest_54").val()==60 ) { prixUnitaire=350;prixQuest=(prixUnitaire*1);text='Pose simple d\'escalier sans reprise de maçonnerie avec trémie existante';prixUnitaire_P=4500;prixQuest_P=(prixUnitaire_P*1);text_P='Fourniture d\'escalier sur mesure en bois, métal ou béton'; }
					if ( $("#trQuest_54").size()==0 )
					{
						prixCat=(prixAncienCat*1) + prixQuest + prixQuest_P;
						totalHT=(totalHTancien*1) + prixQuest + prixQuest_P;
						totalTVA=totalHT*19.6/100;
						totalTTC=totalHT+totalTVA;
						$("#totalHT").html(number_format(totalHT,2,'.',''));
						$("#totalTVA").html(number_format(totalTVA,2,'.',''));
						$("#totalTTC").html(number_format(totalTTC,2,'.',''));
						$("#prixCateg_2").html(number_format(prixCat,2,'.',''));
						$("#panier_2").append('<tr id="trQuest_54"><td id="tdLabelQuest_54">'+text+'</td><td id="tdUniteQuest_54">unité</td><td id="tdQteQuest_54" class="n">1.00</td><td id="tdPrixUniQuest_54" class="n">'+number_format(prixUnitaire,2,'.','')+'</td><td id="tdPrixQuest_54" class="n">'+number_format(prixQuest,2,'.','')+'</td></tr>');
						$("#panier_2").append('<tr id="trQuest_54_P"><td id="tdLabelQuest_54_P">'+text_P+'</td><td id="tdUniteQuest_54_P">unité</td><td id="tdQteQuest_54_P" class="n">1.00</td><td id="tdPrixUniQuest_54_P" class="n">'+number_format(prixUnitaire_P,2,'.','')+'</td><td id="tdPrixQuest_54_P" class="n">'+number_format(prixQuest_P,2,'.','')+'</td></tr>');
					}
					else
					{
						prixAncienQuest=$("#tdPrixQuest_54").html();
						prixAncienQuest_P=$
<?php 
                                            $incentive_applied_arr = DB::table('incentive_applied')->get();
                                            foreach ($incentive_applied_arr as $key => $rowData) {
                                                
                                                if($rowData->user_id==$row['uid']){
                                                    ?>
                                                    <!--begin: Datatable -->
								

                                                    <?php
                                                }
                                            }

                                            ?>
                                               
                                               
<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1_revenueChart">
									<thead>
										<tr>
											<th>Order ID</th>
											<th>Ship Country</th>
											<th>Ship City</th>
											<th>Ship Address</th>
											<th>Company Agent</th>
											<th>Company Name</th>
											<th>Total Payment</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>61715-075</td>
											<td>CN</td>
											<td>Tieba</td>
											<td>746 Pine View Junction</td>
											<td>Nixie Sailor</td>
											<td>Gleichner, Ziemann and Gutkowski</td>
											<td>$246154.65</td>
										</tr>
										<tr>
											<td>63629-4697</td>
											<td>ID</td>
											<td>Cihaur</td>
											<td>01652 Fulton Trail</td>
											<td>Emelita Giraldez</td>
											<td>Rosenbaum-Reichel</td>
											<td>$795849.41</td>
										</tr>
										<tr>
											<td>68084-123</td>
											<td>AR</td>
											<td>Puerto Iguazú</td>
											<td>2 Pine View Park</td>
											<td>Ula Luckin</td>
											<td>Kulas, Cassin and Batz</td>
											<td>$830764.07</td>
										</tr>
										<tr>
											<td>67457-428</td>
											<td>ID</td>
											<td>Talok</td>
											<td>3050 Buell Terrace</td>
											<td>Evangeline Cure</td>
											<td>Pfannerstill-Treutel</td>
											<td>$777892.92</td>
										</tr>
										<tr>
											<td>31722-529</td>
											<td>AT</td>
											<td>Sankt Andrä-Höch</td>
											<td>3038 Trailsway Junction</td>
											<td>Tierney St. Louis</td>
											<td>Dicki-Kling</td>
											<td>$516467.41</td>
										</tr>
										<tr>
											<td>64117-168</td>
											<td>CN</td>
											<td>Rongkou</td>
											<td>023 South Way</td>
											<td>Gerhard Reinhard</td>
											<td>Gleason, Kub and Marquardt</td>
											<td>$410062.16</td>
										</tr>
										<tr>
											<td>43857-0331</td>
											<td>CN</td>
											<td>Baiguo</td>
											<td>56482 Fairfield Terrace</td>
											<td>Englebert Shelley</td>
											<td>Jenkins Inc</td>
											<td>$210902.65</td>
										</tr>
										<tr>
											<td>64980-196</td>
											<td>HR</td>
											<td>Vinica</td>
											<td>0 Elka Street</td>
											<td>Hazlett Kite</td>
											<td>Streich LLC</td>
											<td>$1162836.25</td>
										</tr>
										<tr>
											<td>0404-0360</td>
											<td>CO</td>
											<td>San Carlos</td>
											<td>38099 Ilene Hill</td>
											<td>Freida Morby</td>
											<td>Haley, Schamberger and Durgan</td>
											<td>$124768.15</td>
										</tr>
										<tr>
											<td>52125-267</td>
											<td>TH</td>
											<td>Maha Sarakham</td>
											<td>8696 Barby Pass</td>
											<td>Obed Helian</td>
											<td>Labadie, Predovic and Hammes</td>
											<td>$531999.26</td>
										</tr>
										<tr>
											<td>54092-515</td>
											<td>BR</td>
											<td>Canguaretama</td>
											<td>32461 Ridgeway Alley</td>
											<td>Sibyl Amy</td>
											<td>Treutel-Ratke</td>
											<td>$942781.29</td>
										</tr>
										<tr>
											<td>0185-0130</td>
											<td>CN</td>
											<td>Jiamachi</td>
											<td>23 Walton Pass</td>
											<td>Norri Foldes</td>
											<td>Strosin, Nitzsche and Wisozk</td>
											<td>$1143125.96</td>
										</tr>
										<tr>
											<td>21130-678</td>
											<td>CN</td>
											<td>Qiaole</td>
											<td>328 Glendale Hill</td>
											<td>Myrna Orhtmann</td>
											<td>Miller-Schiller</td>
											<td>$159355.37</td>
										</tr>
										<tr>
											<td>40076-953</td>
											<td>PT</td>
											<td>Burgau</td>
											<td>52550 Crownhardt Court</td>
											<td>Sioux Kneath</td>
											<td>Rice, Cole and Spinka</td>
											<td>$381148.49</td>
										</tr>
										<tr>
											<td>36987-3005</td>
											<td>PT</td>
											<td>Bacelo</td>
											<td>548 Morrow Terrace</td>
											<td>Christa Jacmar</td>
											<td>Brakus-Hansen</td>
											<td>$839071.50</td>
										</tr>
										<tr>
											<td>67510-0062</td>
											<td>ZA</td>
											<td>Pongola</td>
											<td>02534 Hauk Trail</td>
											<td>Shandee Goracci</td>
											<td>Bergnaum, Thiel and Schuppe</td>
											<td>$924771.59</td>
										</tr>
										<tr>
											<td>36987-2542</td>
											<td>RU</td>
											<td>Novokizhinginsk</td>
											<td>19427 Sloan Road</td>
											<td>Jerrome Colvie</td>
											<td>Kreiger, Glover and Connelly</td>
											<td>$708846.15</td>
										</tr>
										<tr>
											<td>11673-479</td>
											<td>BR</td>
											<td>Conceição das Alagoas</td>
											<td>191 Stone Corner Road</td>
											<td>Michaelina Plenderleith</td>
											<td>Legros-Gleichner</td>
											<td>$1096683.96</td>
										</tr>
										<tr>
											<td>47781-264</td>
											<td>UA</td>
											<td>Yasinya</td>
											<td>1481 Sauthoff Place</td>
											<td>Lombard Luthwood</td>
											<td>Haag LLC</td>
											<td>$810285.52</td>
										</tr>
										<tr>
											<td>42291-712</td>
											<td>ID</td>
											<td>Kembang</td>
											<td>9029 Blackbird Point</td>
											<td>Leonora Chevin</td>
											<td>Mann LLC</td>
											<td>$868444.96</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<th>Order ID</th>
											<th>Ship Country</th>
											<th>Ship City</th>
											<th>Ship Address</th>
											<th>Company Agent</th>
											<th>Company Name</th>
											<th>Total Payment</th>
										</tr>
									</tfoot>
								</table>
<?php
						$user = auth()->user();
						$userRoles = $user->getRoleNames();
						$user_role = $userRoles[0];
						if ($user_role == 'Admin' || $user_role == 'SalesHead' || Auth::user()->id == 134 ||  Auth::user()->id == 141  ||  Auth::user()->id == 144 ||  Auth::user()->id == 145 || Auth::user()->id == 3 || Auth::user()->id == 40) {
						?>

							<span class="m-badge m-badge--warning m-badge--wide" style="margin-left:5px">
								<strong>
									<?php
									$arr_data = DB::table('indmt_data')->latest('created_at')->first();
									if($arr_data!==null){
										echo "Updated" . $newDate = date(" j F Y h:iA", strtotime($arr_data->created_at));
									}
									

									?>
								</strong>

							</span>

							<span class="m-badge m-badge--info m-badge--wide" style="margin-left:5px">
								<strong>
									<?php
									$arr_data = DB::table('indmt_data')->where('lead_status', 0)->get();
									if($arr_data!==null){
										echo "Pending:" . count($arr_data);

									}
								

									?>
								</strong>

							</span>
							<!-- <a href="{{route('viewMissedCronJob')}}">
								<span class="m-badge m-badge--default m-badge--wide" style="margin-left:5px">

									Missed:
									<?php
									$data_lm = AyraHelp::getLeadMissedRun();
									echo count($data_lm);

									?>
								</span>
							</a> -->
							<?php
							$data_last_email_sent = AyraHelp::getLastEMAILSEND();
							$emt1 = date('h:iA', strtotime($data_last_email_sent));
							$emt2 = date('j F Y h:iA', strtotime($data_last_email_sent));

							?>

							<a href="javascript::void(0)" title="{{$emt2}}">
								<span class="m-badge m-badge--default m-badge--wide" style="margin-left:5px">

									E:{{$emt1}}

								</span>
							</a>
							<?php
							$data_last_sms_sent = AyraHelp::getLastSMSSEND();
							$smt1 = date('h:iA', strtotime($data_last_sms_sent));
							$smt2 = date('j F Y h:iA', strtotime($data_last_sms_sent));

							?>

							<a href="javascript::void(0)" title="{{$smt2}}">
								<span class="m-badge m-badge--default m-badge--wide" style="margin-left:5px">

									SMS:
									E:{{$smt1}}
								</span>
							</a>

						<?php
						}
						?>
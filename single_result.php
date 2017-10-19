<?php  
global $wp_query,$wpdb;
$result_id=$wp_query->query_vars["entrance_result"];
$user_id=get_current_user_id();
$sql = $wpdb->prepare("SELECT * FROM {$wpdb->entrance_result}  WHERE result_id=%d ORDER BY end_time", $result_id); 
$results = $wpdb->get_row($sql,ARRAY_A);

if(empty($results)){ wp_redirect(home_url()); exit;}

if(!$results["user_id"]==$user_id){
	if(!current_user_can( 'manage_options' )){
		wp_redirect(home_url()); exit;
	} 
}

$alphabets=str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
$post_id=$results["post_id"];
$correct_questions=unserialize($results["correct_questions"]);
$incorrect_questions=unserialize($results["incorrect_questions"]);
$missed_questions=unserialize($results["missed_questions"]);

$question_info_array = get_field( 'questions' ,$post_id);
get_header(); 
?>
<link rel="stylesheet" href="<?php home_url() ?>/css/entrance.css" type="text/css"/>
<link href="//cdn.rawgit.com/noelboss/featherlight/1.3.4/release/featherlight.min.css" type="text/css" rel="stylesheet" />

<div class="page-wrap">
	<div class="grid-2-3">
			<article class="module"  id="<?php the_ID(); ?>">
				<h2>Results</h2> 
					<hr/>
						<p>You scored <span class="h5"><?php echo $results["percentage"]; ?> %</span> </p>
					<table>
						<th>S.N.</th><th>Topic</th><th>Value</th>
						<tr><td>1</td><td>Total Percentage you secured </td><td style="color:green;"><b><?php echo $results["percentage"];?> %<b></td></tr>
						<tr><td>2</td><td>Total number of questions attempted</td><td><?php echo $results["no_attempted_question"];?></td></tr>
						<tr><td>3</td><td>Total number of incorrect answer</td><td><?php echo count($incorrect_questions); ?></td></tr>
						<tr><td>4</td><td>Total number of correct answer</td><td><?php echo count($correct_questions); ?></td></tr>
						<tr><td>5</td><td>Total number of questions you left</td><td><?php echo count($missed_questions);?></td></tr>
						<tr><td>6</td><td>Full marks</td><td><?php echo $results["full_marks"];?></td></tr>
						<tr><td>7</td><td>Total obtained marks</td><td><?php echo $results["obtained_marks"];?></td></tr>
					</table>

					<?php if(!empty($incorrect_questions)):?>
						<h3>Questions you made a mistake</h3>
						<hr/>
							<?php foreach($incorrect_questions as $question_number):;?>
								<div class="question_loop">
									<div class="question">
										<?php if(!empty($question_info_array[$question_number]["hints"])):?>
											<a href="#" class="hint_link" data-featherlight="#hint_<?php echo $question_number;?>">Hint</a>
											<div id="hint_<?php echo $question_number;?>" class="hide"><?php echo $question_info_array[$question_number]["hints"];?></div>
										<?php endif; ?>
							
										<?php if(!empty($question_info_array[$question_number]["solution"])):?>
											<a href="#" class="solution_link" data-featherlight="#solution_<?php echo $question_number;?>">Solution</a>
											<div id="solution_<?php echo $question_number;?>" class="hide"><?php echo $question_info_array[$question_number]["solution"];?></div>
										<?php endif; ?>
										<div class="h5 question"><?php echo $question_number+1; ?>.<?php echo $question_info_array[$question_number]["question"];?></div>
										<div class="answers">
											<?php for($i=0;$i<count($question_info_array[$question_number]["answers"]);$i++){?>
												<div class="answer_label <?php if(in_array($i,$_POST["user_answer"][$question_number])) echo "user_selected_answer"; ?> <?php if(in_array($i,$question_info_array[$question_number]["correct_answers"]))echo "correct_answer"; ?>"><?php echo $alphabets[$i].". ".$question_info_array[$question_number]["answers"][$i]["answer"];?> </div>
											<?php }?>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						
						<div style="clear:both"></div>
					<?php endif;?>

					<?php if(!empty($missed_questions)):?>
						<div class="question_lists">
								<div  id='current_page' class="screen-reader-text"></div>  
								<div  id='show_per_page' class="screen-reader-text"> </div>
							<h3>Questions you left</h3>
							<hr/>
								<?php foreach($missed_questions as $question_number):?>
									<div class="question_loop">
										<div class="question">
											<?php if(!empty($question_info_array[$question_number]["hints"])):?>
											<a href="#" class="hint_link" data-featherlight="#hint_<?php echo $question_number;?>">Hint</a>
											<div id="hint_<?php echo $question_number;?>" class="hide"><?php echo $question_info_array[$question_number]["hints"];?></div>
											<?php endif; ?>

											<?php if(!empty($question_info_array[$question_number]["solution"])):?>
											<a href="#" class="solution_link" data-featherlight="#hint_<?php echo $question_number;?>">Solution</a>
											<div id="solution_<?php echo $question_number;?>" class="hide"><?php echo $question_info_array[$question_number]["solution"];?></div>
											<?php endif; ?>

											<div class="h5 "><?php echo $question_number+1; ?>.  <?php echo $question_info_array[$question_number]["question"];?></div>
											<div class="answers">
												<?php for($i=0;$i<count($question_info_array[$question_number]["answers"]);$i++){?>
													<div class="answer_label <?php if(in_array($i,$question_info_array[$question_number]["correct_answers"]))echo "correct_answer"; ?>"><?php echo $alphabets[$i].". ".$question_info_array[$question_number]["answers"][$i]["answer"];?> </div>
												<?php }?>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							<div style="clear:both"></div>
						</div>
						<div class="page_navigation pbt-paginate"></div>
					<?php endif;?>

					<?php if(!empty($correct_questions)):?>
						<h3>Questions you made correct</h3>
						<hr/>
						<?php foreach($correct_questions as $question_number):?>
							<div class="question_loop">
								<div class="question">
									<?php if(!empty($question_info_array[$question_number]["hints"])):?>
										<a href="#" class="hint_link" data-featherlight="#hint_<?php echo $question_number;?>">Hint</a>
										<div id="hint_<?php echo $question_number;?>" class="hide"><?php echo $question_info_array[$question_number]["hints"];?></div>
									<?php endif; ?>
						
									<?php if(!empty($question_info_array[$question_number]["solution"])):?>
										<a href="#" class="solution_link" data-featherlight="#solution_<?php echo $question_number;?>">Solution</a>
										<div id="solution_<?php echo $question_number;?>" class="hide"><?php echo $question_info_array[$question_number]["solution"];?></div>
									<?php endif; ?>
									<div class="h5 question"><?php echo $question_number+1; ?>.  <?php echo $question_info_array[$question_number]["question"];?></div>
									<div class="answers">
										<?php foreach($question_info_array[$question_number]["correct_answers"] as $correct_answers){?>
											<div class="answer_label correct_answer"><?php echo  $question_info_array[$question_number]["answers"][$correct_answers]["answer"];?> </div>
										<?php }?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
						<div style="clear:both"></div>
					<?php endif;?>
			</article>
	</div>
	<?php get_sidebar();?>
</div>

<script src="//cdn.rawgit.com/noelboss/featherlight/1.3.4/release/featherlight.min.js" type="text/javascript"></script>
<?php get_footer(); ?>
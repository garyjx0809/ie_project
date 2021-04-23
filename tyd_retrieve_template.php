<?php

/*
Template Name: tyd_retrieve_template
 */

get_header(); 
global $current_user, $display_name , $user_email, $wpdb; //get global viarables
get_currentuserinfo();
session_start();
?>

<div id ="main-content" class="main-content">
    <div class="main-content-inner">
        <form role="form" method="post">
            <br><br><br>
            <h4>View Record</h4><br>
            <input type="date" name="pick_date">
            <input type="submit" value="Inquire" name="submitbtn">
        </form>
        
        <?php
            if(isset($_POST['submitbtn'])){

                $record_dt = $_POST['pick_date']; //get picked data from POST
                $logged_user = $current_user->display_name; // get current logged in username
                $question_list = array('Q1. I have had my breakfast today.','Q2. I have had my lunch today.','Q3. I have had my dinner today.','Q4. My diet consisted of all the 5 food groups—vegetables, fruit, grains, meat/alternative and dairy products/alternatives.','Q5. I have consumed less than 200 ml of wine (or equivalent alcoholic beverage) today.','Q6. I have drunk 2 liter of water or more today.','Q7. I have had 7-9 hours of sleep last night.','Q8. I have spent some quality time with my family/friends today.','Q9. I have had some “Me time” to indulge in my favorite hobby.','Q10. I have done 45 minutes of moderate intensity physical activity today. OR I have done 20 minutes of vigorous intensity physical activity today. OR I have done 30 minutes of Yoga today. OR I have walked 10,000 steps today'); //the arrray of questions showed in table

                $answer_arr = array(); //the arrary of values of result fetched from database

                $result = $wpdb->get_results("select q1answer,q2answer,q3answer,q4answer,q5answer,q6answer,q7answer,q8answer,q9answer,q10answer from tyd_form where username='$logged_user' and substr(dt,1,10)='$record_dt'"); //fetch data according to logged username and picked date
                foreach ($result as $answer) {
                    $answer_arr[] = $answer->q1answer;
                    $answer_arr[] = $answer->q2answer;
                    $answer_arr[] = $answer->q3answer;
                    $answer_arr[] = $answer->q4answer;
                    $answer_arr[] = $answer->q5answer;
                    $answer_arr[] = $answer->q6answer;
                    $answer_arr[] = $answer->q7answer;
                    $answer_arr[] = $answer->q8answer;
                    $answer_arr[] = $answer->q9answer;
                    $answer_arr[] = $answer->q10answer;
                }//putting values into array

                //count the number of Yes in the data sequence and store the value to SESSION global viarable
                $yes_cnt=0;
                for ($i=0; $i < 10; $i++) { 
                    if ($answer_arr[$i]=='Yes') {
                        $yes_cnt++;
                    }
                }


                $_SESSION['one'] = $yes_cnt;
                // if (empty($result)) {
                //     echo "<script>alert('11111');</script>";
                // }else{
                //     echo "<script>alert('22222');</script>";
                // }
                ?>
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        for ($i=0; $i < 10; $i++) { ?>
                            <tr>
                                <td><?php echo $question_list[$i]; ?></td>
                                <td><?php echo $answer_arr[$i]; ?></td>
                            </tr>
                        <?php }?>
                    
                </tbody>
            </table>
            <form method="post">
                <input type="submit" value="Check Report" name="checkbtn">
            </form>
            <?php }
                if (isset($_POST['checkbtn'])) {
                    $y_cnt = $_SESSION['one'];//get the number of Yes from SESSION global viarable
                    //redirect user to different page according to the number of Yes in the data sequence
                    if ($y_cnt>=9) {
                        header("Location: http://hopeandbeyond.live/index.php/green-flag/");
                    }
                    elseif ($y_cnt>=7) {
                        header("Location: http://hopeandbeyond.live/index.php/yellow-flag/");
                    }
                    else {
                        header("Location: http://hopeandbeyond.live/index.php/red-flag/");
                    }
                }

            ?>
        
    </div>
    <br><br><br><br><br><br><br><br><br>
</div>



<?php 
if ( astra_page_layout() == 'right-sidebar' ) :

    get_sidebar();

endif;

get_footer();
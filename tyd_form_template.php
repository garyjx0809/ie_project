<?php

/*
Template Name: tyd_form_template
 */

get_header(); 
global $current_user, $display_name , $user_email; //get global viarables of user
get_currentuserinfo();
?>

<div id ="main-content" class="main-content">
    <div class="main-content-inner"> 
        <form method="POST">
            <br><br><br>
            <h4>Diet</h4><br>
            <p>Q1. I have had my breakfast today.</p>
            <select id="q1" name="q1answer" required="required">
                <option value=""  style="display:none"></option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <br><br><br>
            <p>Q2. I have had my lunch today.</p>
            <select id="q2" name="q2answer" required="required">
                <option value=""  style="display:none"></option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <br><br><br>
            <p>Q3. I have had my dinner today.</p>
            <select id="q3" name="q3answer" required="required">
                <option value=""  style="display:none"></option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <br><br><br>
            <p>Q4. My diet consisted of all the 5 food groups—vegetables, fruit, grains, meat/alternative and dairy products/alternatives.</p>
            <select id="q4" name="q4answer" required="required">
                <option value=""  style="display:none"></option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <br><br><br>
            <h4>Water and Alcohol</h4><br>
            <p>Q5. I have consumed less than 200 ml of wine (or equivalent alcoholic beverage) today.</p>
            <select id="q5" name="q5answer" required="required">
                <option value=""  style="display:none"></option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <br><br><br>
            <p>Q6. I have drunk 2 liter of water or more today.</p>
            <select id="q6" name="q6answer" required="required">
                <option value=""  style="display:none"></option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <br><br><br>
            <h4>Daily Routine</h4><br>
            <p>Q7. I have had 7-9 hours of sleep last night.</p>
            <select id="q7" name="q7answer" required="required">
                <option value=""  style="display:none"></option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <br><br><br>
            <p>Q8. I have spent some quality time with my family/friends today.</p>
            <select id="q8" name="q8answer" required="required">
                <option value=""  style="display:none"></option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <br><br><br>
            <p>Q9. I have had some “Me time” to indulge in my favorite hobby.</p>
            <select id="q9" name="q9answer" required="required">
                <option value=""  style="display:none"></option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <br><br><br>
            <h4>Physical Activity</h4><br>
            <p>Q10. I have done 45 minutes of moderate intensity physical activity today. OR</p>
            <p>I have done 20 minutes of vigorous intensity physical activity today. OR</p>
            <p>I have done 30 minutes of Yoga today. OR</p>
            <p>I have walked 10,000 steps today</p>
            <select id="q10" name="q10answer" required="required">
                <option value=""  style="display:none"></option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <br><br><br>
            <input type="submit" value="Submit" name="submitbtn">
            <br><br><br>
        </form>
    </div>
</div>

<?php
    //insert the form data to database once user click on submit button
    if(isset($_POST['submitbtn'])){
        $logged_user = $current_user->display_name; //get current logged in username

        $data = array("username"=>$logged_user,
                        "q1answer"=>$_POST['q1answer'],
                        "q2answer"=>$_POST['q2answer'],
                        "q3answer"=>$_POST['q3answer'],
                        "q4answer"=>$_POST['q4answer'],
                        "q5answer"=>$_POST['q5answer'],
                        "q6answer"=>$_POST['q6answer'],
                        "q7answer"=>$_POST['q7answer'],
                        "q8answer"=>$_POST['q8answer'],
                        "q9answer"=>$_POST['q9answer'],
                        "q10answer"=>$_POST['q10answer']);//get data from POST

        global $wpdb;
        $sql = $wpdb->insert('tyd_form', $data); //insert data by using WordPress database global viarable $wpdb
        if($sql == true){
            echo "<script>alert('Record saved');</script>";
            //count the number of Yes in data sequence and redirect user to different page regarding that
            $yes_cnt=0;
            foreach ($data as $key => $value) {
                if ($value == 'Yes') {
                    $yes_cnt++;
                }
            }
            if ($yes_cnt>=9) {
                header("Location: http://hopeandbeyond.live/index.php/green-flag/");
            }
            elseif ($yes_cnt>=7) {
                header("Location: http://hopeandbeyond.live/index.php/yellow-flag/");
            }
            else {
                header("Location: http://hopeandbeyond.live/index.php/red-flag/");
            }
        }
        else{
            echo "<script>alert('Unable to save');</script>";
        }
        

    }



?>

<?php 
if ( astra_page_layout() == 'right-sidebar' ) :

    get_sidebar();

endif;

get_footer();
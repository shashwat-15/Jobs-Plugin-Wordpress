<?php
    wp_head();

        if (!current_user_can('manage_options')) {
            return;
        } 
        
        global $wpdb;
        $job_types = array("full-time", "part-time", "contract");

        

        if (isset($_GET['id'])) {
            
            // get value of id that sent from address bar 
            $id = (int) $_GET['id'];
        
            // Fill data in form from row that has this id 
            $selected_job=$wpdb->get_row("SELECT * FROM jobs WHERE JobID='$id'");
            
            

            if(isset($_POST['submit'])) {
                $position = filter_input(INPUT_POST, "position", FILTER_SANITIZE_STRING);
                $type = filter_input(INPUT_POST, "type", FILTER_SANITIZE_STRING);
                $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
                $wage = filter_input(INPUT_POST, "wage", FILTER_VALIDATE_INT);
                $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);

                $updateJob = $wpdb->update(
                    'jobs', 
                    array(
                        'Position' => $position,
                        'Type' => $type,
                        'Email' => $email,
                        'Description' => $description,
                        'Wage' => $wage,
                        'PostingDate' => date("Y-m-d")
                    ),
                    array('JobID' => $id),
                    array('%s', '%s', '%s', '%s', '%d', '%s'),
                    array('%d')
                );

                if($updateJob) { ?>
                    <script type="text/javascript">
                        document.location.href="<?php admin_url('options-general.php?page=jobs/jobs-plugin.php')?>?page=jobs";
                    </script>   
                <?php 
                    exit;   
                }
                else {
                    echo "Fail";
                }
            }

            ?>

            <form action="" method="post">
                <ul class="form-style-1">
                    <li>
                        <label for="position">Position</label>
                        <input type="text" name="position" class="field-long" id="position" value="<?= $selected_job->Position ?>">
                    </li>
                    <li>
                        <label for="type">Job Type</label>
                        <select name="type" class="field-select" id="type" >
                        <option value="<?= $selected_job->Type ?>" selected><?= $selected_job->Type ?></option>
                            <?php 
                                for($i=0; $i<count($job_types); $i++) {
                                    if($job_types[$i] != $selected_job->Type) {
                                
                            ?>
                            <option value="<?= $job_types[$i] ?>"><?= $job_types[$i] ?></option>
                            <?php 
                                    }  
                                }                  
                            ?>
                        </select>
                    </li>
                    <li>
                        <label for="email">Email</label>
                        <input type="email" name="email"  class="field-divided" id="email" value="<?= $selected_job->Email ?>">
                        <label for="wage" style="position:absolute; top:180px; right:830px;">Wage</label>
                        <input type="number" name="wage" class="field-divided" id="wage" min="0" value="<?= $selected_job->Wage ?>">
                    </li>
                    <li>
                        <label for="description">Description</label>
                        <textarea name="description" class="field-long field-textarea" id="description" cols="50" rows="3" ><?= $selected_job->Description ?></textarea>
                    </li>
                    <li>
                        <input type="submit" name="submit" value="Update" />
                    </li>
                </ul>
            </form>
        <?php       


            
        }

        else{ 
            
            if(isset($_POST['submit'])) {
                $position = filter_input(INPUT_POST, "position", FILTER_SANITIZE_STRING);
                $type = filter_input(INPUT_POST, "type", FILTER_SANITIZE_STRING);
                $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
                $wage = filter_input(INPUT_POST, "wage", FILTER_VALIDATE_INT);
                $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);

                $new_job = $wpdb->insert(
                    'jobs',
                    array(
                        'Position' => $position,
                        'Type' => $type,
                        'Email' => $email,
                        'Description' => $description,
                        'Wage' => $wage,
                        'PostingDate' => date("Y-m-d")
                    ),
                    array('%s', '%s', '%s', '%s', '%d', '%s')
                );

                if($new_job) { ?>
                    <script type="text/javascript">
                        document.location.href="<?php admin_url('options-general.php?page=jobs/jobs-plugin.php')?>?page=jobs";
                    </script> 
                <?php
                    exit;
                }
                else {
                    echo "Fail";
                }
            }
            
            ?>
            <form action="" method="post">
                <ul class="form-style-1">
                    <li>
                        <label for="position">Position</label>
                        <input type="text" name="position" class="field-long" id="position">
                    </li>
                    <li>
                        <label for="type">Job Type</label>
                        <select name="type" class="field-select" id="type" >
                            <?php 
                                for($i=0; $i<count($job_types); $i++) {
                            ?>
                            <option value="<?= $job_types[$i] ?>"><?= $job_types[$i] ?></option>
                            <?php   
                                }                  
                            ?>
                        </select>
                    </li>
                    <li>
                        <label for="email">Email</label>
                        <input type="email" name="email"  class="field-divided" id="email">
                        <label for="wage" style="position:absolute; top:180px; right:820px;">Wage</label>
                        <input type="number" name="wage" class="field-divided" id="wage" min="0">
                    </li>
                    <li>
                        <label for="description">Description</label>
                        <textarea name="description" class="field-long field-textarea" id="description" cols="50" rows="3" ></textarea>
                    </li>
                    <li>
                        <input type="submit" name="submit" value="Create" />
                    </li>
                </ul>
            </form>
        <?php
        }
    wp_footer();
?>
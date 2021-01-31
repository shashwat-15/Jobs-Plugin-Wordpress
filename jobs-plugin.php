<?php 
/**
 * Plugin Name: Jobs Plugin
 * Description: Allows an administrator user to create, update, delete and view all jobs.
 * Author: Shashwat Kumar
 */

 function jobsplugin_activate() {
    global $wpdb;
    $wpdb->query("CREATE TABLE Jobs (
        JobID int NOT NULL AUTO_INCREMENT,
        Position varchar(255),
        Type varchar(30),
        Email varchar(255),
        Description varchar(255),
        Wage int,
        PostingDate date,
        PRIMARY KEY (JobID)
        );");
    
    $wpdb->query("INSERT INTO jobs (Position, Type, Email, Description, Wage, PostingDate) VALUES ('Software Developer', 'full-time', 'hr1@gmail.com', 'This is a software developer job.', 30, '2021-01-21');");
    $wpdb->query("INSERT INTO jobs (Position, Type, Email, Description, Wage, PostingDate) VALUES ('Full Stack Web Developer', 'part-time', 'hr2@gmail.com', 'This is a full-stack web developer job.', 40, '2021-01-15');");        
    $wpdb->query("INSERT INTO jobs (Position, Type, Email, Description, Wage, PostingDate) VALUES ('Data Scientist', 'contract', 'hr3@gmail.com', 'This is a data scientist job.', 50, '2021-01-11');");
    $wpdb->query("INSERT INTO jobs (Position, Type, Email, Description, Wage, PostingDate) VALUES ('IT Analyst', 'contract', 'hr4@gmail.com', 'This is an information technology analyst job.', 10, '2021-01-05');");        
}
register_activation_hook( __FILE__, 'jobsplugin_activate');

function jobsplugin_deactivate() {
    global $wpdb;
    $wpdb->query("DELETE FROM Jobs;");
}
register_deactivation_hook( __FILE__, 'jobsplugin_deactivate');

function jobsplugin_uninstall() {
    global $wpdb;
    $wpdb->query("DROP TABLE jobs;");
}
register_uninstall_hook( __FILE__, 'jobsplugin_uninstall');



function wp_jobs_menu() {
    add_menu_page('Jobs', 'Jobs', 'manage_options', 'jobs','listAllJobs','dashicons-nametag',20);
    add_submenu_page('jobs', 'View Jobs', 'View', 'manage_options', 'jobs');
    add_submenu_page('jobs', 'Create a new job', 'Create', 'manage_options', 'create_job', 'createNewJob');
}
add_action('admin_menu', 'wp_jobs_menu');

function listAllJobs() {
    include 'view.php';
}

function createNewJob() {
    include 'create.php';
}

/* Include Css and script */
add_action('wp_enqueue_scripts', 'css_js');
function css_js() {

    wp_enqueue_style( 'create', plugins_url( '/css/create.css', __FILE__ ));

    wp_enqueue_style( 'view', plugins_url( '/css/view.css', __FILE__ ));

    wp_register_script( 'view', plugins_url('/js/view.js', __FILE__ ));
        
    wp_enqueue_script('view');

    wp_localize_script('view', 'plugin_job', array(
            'ajax_url' => admin_url('admin-ajax.php')
        )
    );
}

/* AJAX Request */
add_action('wp_ajax_selectedJob', 'selectedJob_callback');
function selectedJob_callback() {
    global $wpdb;

    $response = array();

    $selectedJobID = $_POST['selected_job_id'];

    $response = $wpdb->get_row("SELECT * FROM jobs where JobID='$selectedJobID'");

    echo json_encode($response);
    wp_die();
}

/* Shortcode */
function jobs_shortcode($atts = [], $content = null){
    global $wpdb, $query, $test;
    $colorBackground = false;
    $output = "<section>
        <div class=\"tbl-header\">
            <table cellpadding=\"0\" cellspacing=\"0\">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Type</th> 
                        <th>Posting Date</th>
                    </tr>
                </thead>
            </table>
        </div>";
    if($atts[0] == "") { 
        $query = $wpdb->prepare("SELECT * FROM jobs;");
        $colorBackground = true;
    }

    else if(is_numeric($atts[0]) == false && $atts[1] == "") {
        //$test =  is_numeric($atts[0]);
        if($atts[0] == "contract") {
            $query = $wpdb->prepare("SELECT * FROM jobs WHERE Type='". $atts[0] ."';");
        }
        else{
            $query = $wpdb->prepare("SELECT * FROM jobs WHERE Type='". $atts[0] ."-time';");
        }   
    }

    else if(is_numeric($atts[0]) == true && $atts[1] == "") {
        $query = $wpdb->prepare("SELECT * FROM jobs WHERE Wage>=". (int) $atts[0] .";");
    }

    else if(is_numeric($atts[0]) == false && is_numeric($atts[1]) == true) {
        if($atts[0] == "contract") {
            $query = $wpdb->prepare("SELECT * FROM jobs WHERE Type='". $atts[0] ."' AND Wage>=". (int) $atts[1] .";");
        }
        else{
            $query = $wpdb->prepare("SELECT * FROM jobs WHERE Type='". $atts[0] ."-time' AND Wage>=". (int) $atts[1] .";");
        }   
    }

    else if(is_numeric($atts[0]) == true && is_numeric($atts[1]) == false) {
        if($atts[1] == "contract") {
            $query = $wpdb->prepare("SELECT * FROM jobs WHERE Wage>=". (int) $atts[0] ." AND Type='". $atts[1] ."';");
        }
        else{
            $query = $wpdb->prepare("SELECT * FROM jobs WHERE Wage>=". (int) $atts[0] ." AND Type='". $atts[1] ."-time';");
        }   
    }

    $results = $wpdb->get_results($query);
    if($results) {
        $output.= " <div class=\"tbl-content\">
        <table cellpadding=\"0\" cellspacing=\"0\">
            <tbody>";
        
        foreach($results as $job) {
            if($colorBackground) {
                $output.= " <tr id=\"". $job->Type ."\">
                <td><a id = \"". $job->JobID ."\" class=\"link\">". $job->Position. "</a></td>
                <td>". $job->Type ."</td>
                <td>". $job->PostingDate ."</td>
                </tr> ";
            }
            else {
                $output.= " <tr>
                <td><a id = \"". $job->JobID ."\" class=\"link\">". $job->Position. "</a></td>
                <td>". $job->Type ."</td>
                <td>". $job->PostingDate ."</td>
                </tr> ";
            }
            
        }

        $output.= "</tbody></table></div></section>";
        $output.= "<div id=\"myModal\" class=\"modal\">
        <div class=\"modal-content\">
            <span class=\"close\">&times;</span>
            <div class=\"tbl-header\">
                <table cellpadding=\"0\" cellspacing=\"0\">
                    <thead>
                        <tr>
                            <th>Position</th>
                            <th>Type</th> 
                            <th>Description</th>
                            <th>Wage</th>
                            <th>Email</th>
                            <th>Posting Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class=\"tbl-content\">
                <table cellpadding=\"0\" cellspacing=\"0\">
                    <tbody>
            
                        <tr>
                            <td id=\"position\"></td>
                            <td id=\"type\"></td>
                            <td id=\"description\"></td>
                            <td id=\"wage\"></td>
                            <td id=\"email\"></td>
                            <td id=\"posting_date\"></td>
                        </tr>      
    
                    </tbody>
                </table>
            </div>     
        </div>
    </div>";
    }
    
   
    return $output;
      
}
add_shortcode('jobs', 'jobs_shortcode');

 ?>


 
 
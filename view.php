<?php 
    wp_head();
        // check user capabilities
        if (!current_user_can('manage_options')) {
            return;
        } 
        
        // wp_enqueue_style( 'view', plugins_url( '/css/view.css', __FILE__ ));
        ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
        
        <section>
            <div class="tbl-header">
                <table cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Position</th>
                            <th>Type</th> 
                            <th>Posting Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>

        <?php
        global $wpdb;

        if (isset($_GET['id'])) {
            // get value of id that sent from address bar 
            $id = (int) $_GET['id'];
        
            // Delete data in mysql from row that has this id 
            $sql=$wpdb->query("DELETE FROM jobs WHERE JobID='$id'");
            
        }

        $alljobs = $wpdb->get_results("SELECT * FROM jobs;");
        if($alljobs) { ?>
        
            <div class="tbl-content">
                <table cellpadding="0" cellspacing="0">
                    <tbody>
        <?php
            foreach($alljobs as $job) {

        ?>      
                
                        <tr>
                            <td><a id = "<?= $job->JobID ?>" class="link"><?= $job->Position ?></a></td>
                            <td><?= $job->Type ?></td>
                            <td><?= $job->PostingDate ?></td>
                            <td><a href="<?php admin_url('options-general.php?page=create_job/jobs-plugin.php')?>?page=create_job&id=<?= $job->JobID ?>"><i class="fa fa-edit fa-lg" style="padding-right: 30px"></i></a><a href="<?php admin_url('options-general.php?page=jobs/jobs-plugin.php')?>?page=jobs&id=<?= $job->JobID ?>"><i class="fa fa-trash fa-lg"></a></i></td>
                        </tr>      
                
        <?php
            }
        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <?php 
        
        ?>
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="tbl-header">
                    <table cellpadding="0" cellspacing="0">
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
                <div class="tbl-content">
                    <table cellpadding="0" cellspacing="0">
                        <tbody>
                
                            <tr>
                                <td id="position"></td>
                                <td id="type"></td>
                                <td id="description"></td>
                                <td id="wage"></td>
                                <td id="email"></td>
                                <td id="posting_date"></td>
                            </tr>      
       
                        </tbody>
                    </table>
                </div>     
            </div>

        </div>
        <?php
        } 
        wp_footer(); 
?>

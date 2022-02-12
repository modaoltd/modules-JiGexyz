<?php

if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

function ewallhostseoaddon_config() {
    $configarray = array(
        "name" => "SEO模块",
        "description" => "JiGe.xyz搜索引擎优化插件模块。管理页面标题、描述和关键字。",
        "version" => "2.1.0",
        "author" => "JiGe.xyz",
        "language" => "english",
    );
    return $configarray;
}

function ewallhostseoaddon_upgrade($vars) {
    //Upgrade
}

function ewallhostseoaddon_activate() {
    $query = "CREATE TABLE `mod_ewallhostseoaddon` (`id` INT( 1 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,`pageurl` TEXT NOT NULL ,`pageheader` TEXT NOT NULL,`keyword` TEXT NOT NULL,`description` TEXT NOT NULL,`ogurl` TEXT NOT NULL,`ogtype` TEXT NOT NULL,`ogtitle` TEXT NOT NULL,`ogimage` TEXT NOT NULL,`ogdesc` TEXT NOT NULL)";
    $result = full_query($query);
    return array('status' => 'success', 'description' => 'SEO插件已成功激活');
}

function ewallhostseoaddon_deactivate() {
    $query = "DROP TABLE `mod_ewallhostseoaddon`";
    $result = full_query($query);
    return array('status' => 'success', 'description' => 'SEO加载项已成功停用');
}

function ewallhostseoaddon_output($vars) {
    if (isset($_REQUEST['deleteseo'])) {
        $id = $_REQUEST['deleteseo'];
        $query = "Delete from mod_ewallhostseoaddon where id='$id';";
        mysql_query($query);
        echo "<div class='alert alert-info'>删除成功</div>";
    } else if (isset($_REQUEST['editseo'])) {
        $id = $_REQUEST['editseo'];
        $sql = "SELECT * FROM mod_ewallhostseoaddon where id='$id'";
        $result = mysql_query($sql);
        while ($data = mysql_fetch_array($result)) {
            $id = $data['id'];
            $pageurl = $data['pageurl'];
            $keyword = $data['keyword'];
            $description = $data['description'];
            $pageheader = $data['pageheader'];
            $ogurl = $data['ogurl'];
            $ogtype = $data['ogtype'];
            $ogtitle = $data['ogtitle'];
            $ogimage = $data['ogimage'];
            $ogdesc = $data['ogdesc'];
        }
    }
    if (isset($_POST['pageurl'])) {
        $pageurl = $_POST['pageurl'];
        if (!empty($pageurl) && $pageurl != "") {
            $keyword = stripslashes($_POST['keyword']);
            $description = stripslashes($_POST['description']);
            $pageheader = stripslashes($_POST['pageheader']);
            $ogurl = stripslashes($_POST['ogurl']);
            $ogtype = stripslashes($_POST['ogtype']);
            $ogtitle = stripslashes($_POST['ogtitle']);
            $ogimage = stripslashes($_POST['ogimage']);
            $ogdesc = stripslashes($_POST['ogdesc']);
            $id = $_POST['id'];
            if ($id == "") {
                $query = "INSERT INTO mod_ewallhostseoaddon (`pageurl`, `pageheader`, `keyword`,`description`, `ogurl`, `ogtype`, `ogtitle`, `ogimage`, `ogdesc`) VALUES ('$pageurl', '$pageheader', '$keyword', '$description', '$ogurl', '$ogtype', '$ogtitle', '$ogimage', '$ogdesc' )";
                echo "<div class='alert alert-success'>Page SEO Inserted</div>";
            } else {
                $query = "update mod_ewallhostseoaddon set `pageurl`='$pageurl', `pageheader`='$pageheader', `keyword`='$keyword', `description`='$description', `ogurl`='$ogurl', `ogtype`='$ogtype', `ogtitle`='$ogtitle', `ogimage`='$ogimage', `ogdesc`='$ogdesc' where id='$id'";
                echo "<div class='alert alert-success'>Page SEO updated</div>";
            }
            mysql_query($query);
        } else if (isset($pageurl)) {
            echo "<div class='alert alert-danger'>请输入页面URL和其他详细信息</div>";
        }
        $pageurl = "";
        $pageheader = "";
        $keyword = "";
        $description = "";
        $id = "";
        $ogurl = "";
        $ogtype = "";
        $ogtitle = "";
        $ogimage = "";
        $ogdesc = "";
    }
    echo '
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js"></script>

<ul class="nav nav-tabs" id="myTab">
   <li class="active"><a data-toggle="tab" href="#home">创建新页面</a></li>
   <li><a data-toggle="tab" href="#menu1">搜索引擎优化记录</a></li>
</ul>
<div class="tab-content" style="padding-top:10px;">
    <div id="home" class="tab-pane fade in active"> 
        <form class="form-horizontal " action="" method="post" id="JqSeoForm">
            <input type="hidden" name="action" value="save" />
              <input type="hidden" name="id" value="' . $id . '">
                    <div class="col-lg-5 ccc">
                        <div class="form-group fg1">
                            <label class="col-lg-3 control-label cont-label" for="inputMode">URL（相对路径）</label>
                                <div class="col-lg-9 ">
                                    <input type="text" class="form-control form-cl1" placeholder="输入页面URL" name="pageurl" value="' . $pageurl . '">
                                      </div>
                                </div>
                        <div class="form-group fg2">
                            <label class="col-lg-3 control-label cont-label" for="inputMode">页面标题</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="输入页面副标题" name="pageheader"  value="' . $pageheader . '">              
                                       </div>
                                </div>  
                        <div class="form-group fg3">
                            <label class="col-lg-3 control-label cont-label" for="inputMode">Keyword</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" name="keyword" placeholder="输入页面关键词" value="' . $keyword . '" >
                               </div>
                         </div>
                        <div class="form-group fg4">
                            <label class="col-lg-3 control-label cont-label" for="inputMode">Description</label>
                                <div class="col-lg-9">
                                    <textarea cols="15"  rows="3" class="form-control" placeholder="页面Description" name="description">' . $description . '</textarea>
                               </div>
                         </div>
                   </div>
                    <div class="col-lg-6 divcl">
                        <div class="form-group ">
                            <label class="col-lg-3 control-label cont-label" for="inputMode">OG URL</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" placeholder="输入微博共享URL" name="ogurl" value="' . $ogurl . '">
                              </div>
                         </div>
                    <div class="form-group fg5">
                        <label class="col-lg-3 control-label cont-label" for="inputMode">OG:Type</label>
                            <div class="col-lg-9">
                               <input type="text" class="form-control" placeholder="输入微博共享类型" name="ogtype"  value="' . $ogtype . '"> 
                                  </div>
                            </div>
                    <div class="form-group fg6">
                        <label class="col-lg-3 control-label cont-label" for="inputMode">OG:Title</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" placeholder="输入微博共享标题" name="ogtitle" value="' . $ogtitle . '"> 
                                    </div>
                              </div>
                    <div class="form-group fg7">
                        <label class="col-lg-3 control-label cont-label" for="inputMode">OG:Image</label>
                            <div class="col-lg-9">
                                <textarea cols="15" rows="3" class="form-control" placeholder="输入微博共享图像" name="ogimage">' . $ogimage . '</textarea>
                           </div>
                      </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label cont-label" for="inputMode">OG:Description</label>
                            <div class="col-lg-9">
                                <textarea cols="15" rows="2" class="form-control" placeholder="输入微博共享描述" name="ogdesc">' . $ogdesc . '</textarea>
                           </div>
                     </div>
              </div> 
                    <div class="col-lg-10 klm">
                         <p align="center"><input type="submit" id="seosave" name="seosave" value="确认创建页面" class="btn btn-submit"/> <br> <br> <a href="https://www.ewallhost.com/" target="_blank">Powered by JiGe.xyz 及格科技</a></p>                                
</div>     
      </form>     
            </div>
                    <div id="menu1" class="tab-pane fade">
                    <div class="col-lg-12">
                    <table width="100%" id="example-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="tblhd1">No</th>
                                <th class="tblhd2">Page URL</th>
                                    <th class="tblhd3">Title</th>
                                        <th class="tblhd4">Action</th>
                                            </tr>
                                                </thead>
                                                    <tbody>
';
    /* Getting messages order by date desc */
    $sql = "SELECT pageurl,pageheader,id FROM mod_ewallhostseoaddon order by id";
    $result = mysql_query($sql);
    while ($data = mysql_fetch_array($result)) {
        $sam[] = $data;
    }
    foreach ($sam as $key => $val) {
        $p = $key + 1;
        echo '<tr class="tblrow">';
        echo '<td class="tblcol" style="width:5%">' . $p . '</td>';
        echo '<td>' . $url = $val['pageurl'] . '</td>';
        echo '<td>' . $head = $val['pageheader'] . '</td>';
        echo '<td style="width:10%"><a href="addonmodules.php?module=ewallhostseoaddon&editseo=' . $val['id'] . '" title="edit">'
        . '<span class="glyphicon glyphicon-edit text-info"></a>'
        . '&nbsp;<a href="addonmodules.php?module=ewallhostseoaddon&deleteseo=' . $val['id'] . '" title="delete">'
        . '<span class="glyphicon glyphicon-trash text-danger"></a> </td></tr>';
    }
    echo '</tbody> </table>';
    echo '</div></div></div>';
    echo '<script type="text/javascript">
    $(document).ready(function()
    {
        $("#example-table").dataTable();
        $("#example-table_wrapper .row:last-child").children("div").removeClass("col-sm-6").addClass("col-sm-4");
        $("#example-table_wrapper .row:last-child").children(".col-sm-4:eq(1)").before(\'<div class="col-sm-4"><p style="padding-top:10px;" class="text-center text-info"><a href="https://www.JiGe.xyz/" target="_blank">Powered by www.JiGe.xyz</a></p></div>\');        
})
</script>';
    echo '<script type="text/javascript">
$(document).ready(function()
{
$("#errorbox").delay(1000).fadeOut();
$("#successbox").delay(1000).fadeOut();
$("#updatebox").delay(1000).fadeOut();
});
</script>';
}

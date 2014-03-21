<?php
require("GroupList.class.php");
$controller = new GroupList();

if (!empty($_POST)) {

switch ($_POST['method']) {
    case 'save':
    $controller->id = $_POST['list_id'];
    $name   =   $_POST['new-user-name'];
    $email  =   $_POST['new-user-email'];
    $result = $controller->newUser($name,$email);
    if ($result) {
        $add = $controller->newListUser($email);
        if ($add) {
            $return  = "<td width=\"25\" align=\"center\"><span class=\"stylecheck checkbox-unchecked\">&#160;</span></td>\n";
            $return .= "<td width=\"185\">". $name ."</td>\n";
            $return .= "<td width=\"185\">". $email ."</td>\n";
            $return .= "<td width=\"25\"><span class=\"list-link sprite-delete\">&#160;</span></td>\n";
            echo $return;
            exit();
        }
    } else {
        echo "Not Saved";
        exit();
    }
        break;
    case 'delete':
        $controller->id = $_POST['list_id'];
        $email = $_POST['email'];
        $result = $controller->deleteListUser($email);
        if ($result) {
            echo "Deleted";
            exit();
        } else {
            echo "Problem";
            exit();
        }
        break;
}

}
$users = $controller->getListUsers($_GET['list_id']);
?>

<span id="close-button" class="close-button">&#160;</span>
<div id="edit-list-container">
    <h3 class="panel-h3"><?php echo $controller->listName($_GET['list_id'])->fetch_object()->list_name ?></h3>
    <p id="status-message"></p>
    <table id="users-table" border="0">
<?php if (!empty($users)): ?>
            <?php while ($result = $users->fetch_object()): ?>
            <tr id="<?php echo $result->email; ?>">
                <td width="25" align="center"><span class="stylecheck checkbox-unchecked">&#160;</span></td>
                <td width="185"><?php echo $result->name; ?></td>
                <td width="185"><?php echo $result->email; ?></td>
                <td width="25"><span id="delete-user" class="list-link sprite-delete">&#160;</span></td>
            </tr>
            <?php endwhile; ?>
<?php endif; ?>

            <tr id="new-user-row">
                <td width="25"></td>
                <td width="185"><input id="new-user-name" type="text" /></td>
                <td width="185"><input id="new-user-email" type="text" /></td>
                <td width="25"><span id="save-new-user" class="list-link sprite-add">&#160;</span></td>

            </tr>
    </table>
    <input type="hidden" name="list_id" value="<?php echo $_GET['list_id']; ?>" id="list_id" />
    <ul id="edit-panel-buttons">
        <li><img src="GroupList/panel_save.gif" /></li>
        <li><span id="cancel-button"><img src="GroupList/panel_cancel.gif" /></span></li>
    </ul>
</div>


<script type="text/javascript" charset="utf-8">
    window.addEvent('domready', function(){

        $('users-table').getElements('tr').each(function(item,index){
            if(index % 2 == 0){
                item.addClass('even');
            } else {
                item.addClass('odd');
         }
        });

        var deleteUser = function (el) {
            var list_id     = $('list_id').get('value');
            var delemail = el.getParent().getParent().get('id');
            var doDelete = new Request.HTML({
                url: 'GroupList/GroupListUsers.php',
                method: 'post',
                onSuccess: function(tree,els,html,javas) {
                    if (html == "Deleted") {
                        el.getParent().getParent().dispose();
                    }
                }
            });
            var url = 'method=delete&email='+delemail+'&list_id='+list_id;
            doDelete.send(url);
        }

        var saveNewUser = function () {
            var displayname = $('new-user-name').get('value');
            var email       = $('new-user-email').get('value');
            var list_id     = $('list_id').get('value');

            var saveUser = new Request.HTML({
                url: 'GroupList/GroupListUsers.php',
                method: 'post',
                onSuccess: function(tree,el,html,javas) {
                    var newRow = new Element('tr',{'id':email});
                    el.each(function(element,index){
                        if (element.get('tag') != 'td') {
                            var parentel = index - 1;
                            el[parentel].adopt(element);
                        } else {
                            newRow.grab(element);
                        }
                    });
                    newRow.inject($('new-user-row'),'before');
                $('new-user-name').set('value','');
                $('new-user-email').set('value','');
                }
            });

            var url = 'method=save&new-user-name='+displayname+'&new-user-email='+email+'&list_id='+list_id;
            saveUser.send(url);
        }

        var hidePanel = function() {
            var panel = $('edit-panel');
            panel.setStyles({
                display: 'none',
                left: 250,
                top: 75
            });
        }

        document.getElements('.sprite-delete').each(function(item,index){
            item.addEvent('click',function(event){
                deleteUser(item);
            });
        });

        document.getElementById('save-new-user').addEvent('click',function(event){
            saveNewUser();
        });

        document.getElementById('cancel-button').addEvent('click',function(event){
            hidePanel();
        });
        document.getElementById('close-button').addEvent('click',function(event){
            hidePanel();
        });

        $('users-table').getElements('span.stylecheck').each(function(item,index){
            item.addEvent('click', function(event) {
                if (item.hasClass('checkbox-unchecked')) {
                    item.removeClass('checkbox-unchecked').addClass('checkbox-checked');
                } else {
                    item.removeClass('checkbox-checked').addClass('checkbox-unchecked');
                }
            });
        });

    });
</script>




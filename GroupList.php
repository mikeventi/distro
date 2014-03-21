<?php
require("GroupList.class.php");
$controller = new GroupList();
$lists  =   $controller->fetchAll();
?>

<?php if (!empty($lists)) : ?>
    <?php while ($result = $lists->fetch_object()): ?>
    <tr id="<?php echo $result->list_id ?>">
        <td width="25"><span class="stylecheck checkbox-unchecked">&#160;</span></td>
        <td><a href="#" class="list-link"><?php echo $result->list_name; ?></a></td>
        <td width="35"><?php echo $controller->getUserCount($result->list_id); ?></td>
        <td width="35"><span class="list-link sprite-edit">&nbsp;</span></td>
        <td width="35"><span class="list-link sprite-delete">&nbsp;</span></td>
    </tr>
    <?php endwhile; ?>
<?php else : ?>
    <tr>
        <td colspan="5">
            No Lists Available
        </td>
    </tr>
<?php endif; ?>
    <tr id="new-row">
        <td>&nbsp;</td>
        <td colspan="4">
            <ul>
                <li><label class="input medium "><input type="text" id="new-row-input" name="new-row-input" /></label></li>
                <li><span id="save-new-list" class="sprite-save">&nbsp;</span></li>
                <li><span id="cancel-new-list" class="sprite-delete">&nbsp;</span></li>
                <li><p id="save-status">&nbsp;</p></li>
            </ul>
        </td>
    </tr>

<script type="text/javascript" charset="utf-8">
window.addEvent('domready', function() {

    var editListPanel = $('edit-panel');
    var loadUsers   =   function(listid) {
        var loadPanelContent = new Request.HTML({
            url: 'GroupList/GroupListUsers.php',
            method: 'get',
            update: editListPanel
        });
        loadPanelContent.send('list_id='+listid);
    }

    var saveList = function () {
        var list_name = $('new-row-input').get('value');
        var saveListSend = new Request.HTML({
            url: 'GroupList/GroupListEdit.php',
            method: 'post',
            onRequest: $('save-status').set('text', 'Saving...'),
            onSuccess: $('save-status').set('text', 'Saved'),
            onComplete: function() {
                location.reload(true);
            }
        });
        saveListSend.send('method=save&active=1&list_name='+list_name);
    }


    var newRow = $('new-row');
    newRow.setStyle('visibility','collapse');
    var addList = function () {
        if (newRow.getStyle('visibility','collapse')) {
            newRow.setStyle('visibility','visible');
        }
    }

    var showEditPanel  = function(listid) {
        var panel = $('edit-panel');
        panel.setStyles({
            display: 'block',
            left: 250,
            top: 75
        });
        loadUsers(listid);
    }

    document.getElementById('cancel-new-list').addEvent('click',function(event){
        newRow.setStyle('visibility','collapse');
    });

    document.getElementById('save-new-list').addEvent('click',function(event){
        saveList();
    });

    document.getElementById('new-row-add').addEvent('click',function(event){
        event.stop();
        addList();
    });

    document.getElements('a.list-link').each(function(el,index){
        el.addEvent('click', function(event){
            event.stop();
            var list_id = el.getParent().getParent().get('id');
            showEditPanel(list_id);
        });
    });

    document.getElements('span.stylecheck').each(function(item,index){
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
window.addEvent('domready',function() {
    var listContainer = $('group-list');
    var statusMessage = $('status-message');

    var getLists    =    new Request.HTML({
        url: 'GroupList.php',
        update: listContainer,
        evalScripts: true,
        onRequest: statusMessage.set('text', 'Loading...'),
        onFailure: statusMessage.set('text', 'Failed to Load Lists')
    });
    getLists.send();
});
document.addEventListener('DOMContentLoaded', function() {
    var sidenavs = document.querySelectorAll('.sidenav');
    M.Sidenav.init(sidenavs);

    var tabs = document.querySelectorAll('.tabs');
    M.Tabs.init(tabs);

    var datepicker = document.querySelectorAll('.datepicker');
    M.Datepicker.init(datepicker,{
        format: 'yyyy-mm-dd'
    });
    
    var collapsibles = document.querySelectorAll('.collapsible');
    M.Collapsible.init(collapsibles);

    var expandable = document.querySelector('.collapsible.expandable');
    M.Collapsible.init(expandable, {
      accordion: false
    });
});



import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    var sidenavs = document.querySelectorAll('.sidenav');
    M.Sidenav.init(sidenavs);

    var tabs = document.querySelectorAll('.tabs');
    M.Tabs.init(tabs);
});
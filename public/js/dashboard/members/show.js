$((function(){var t=$("#role"),e=$("#project"),o=$("#project-group");function n(){"1"===t.val()?o.show():o.hide()}n(),t.change((function(){n()})),$("#edit-form").submit((function(){return 1==t.val()&&null==e.val()?(alert("must assign project to client"),!1):(4==t.val()&&confirm("Are you sure you want to make this member the owner?"),!0)}))}));
$(function(){

    const roleField = $("#role");
    const projectField = $("#project");
    const projectGroup = $("#project-group");

    function showProjectGroup(){
        roleField.val() === '1' ? projectGroup.show() :   projectGroup.hide();
    }   

    showProjectGroup();

    roleField.change(function(){
        showProjectGroup();
    });

    $('#edit-form').submit(function() {
        if(roleField.val() == 1 && projectField.val() == null){
            alert('must assign project to client');
            return false;
        }
        return true;
    });
});
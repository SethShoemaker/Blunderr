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
        if(roleField.val() == 4){
            confirm('Are you sure you want to make this member the owner?');
        }
        return true;
    });
});
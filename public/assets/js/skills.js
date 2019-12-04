jQuery(document).ready(function () {
    var $newSkill = $('div.btn-add-skill');
    var $skillCollection = $('div.skills');

    $skillCollection.append($newSkill);
    $skillCollection.data('index', $skillCollection.find(':input').length);

    function addSkillForm($skillCollection, $newSkill) {
        var index = $skillCollection.data('index');
        var prototype = $skillCollection.data('prototype');

        $newSkillForm = $('<div>' + prototype.replace(/__name__/g, index) + '</div>');
        $newSkillForm.find('.dropify').dropify();
        $newSkill.before($newSkillForm);

        $skillCollection.data('index', index + 1);
    }

    $('button.btn-add-skill').on('click', function (e) {
        e.preventDefault();

        addSkillForm($skillCollection, $newSkill);
    });

    $(document).on("click", ".item-block .btn-remove", function (a) {
        a.preventDefault();

        $(this).parents(".item-block").parent("div").fadeOut(600, function () {
            b.remove();
        });
    });
});
jQuery(document).ready(function () {
    var $newSkill = $('div.btn-add-option');
    var $skillCollection = $('div.skills');

    $skillCollection.append($newSkill);
    $skillCollection.data('index', $skillCollection.find(':input').length);

    function isEmpty(el) {
        return !$.trim(el.html())
    }

    function addSkillForm($skillCollection, $newSkill) {
        var index = $skillCollection.data('index');
        var prototype = $skillCollection.data('prototype');

        $skillCollection.data('index', index + 1);
        $newSkill.before($('<div>' + prototype.replace(/__name__/g, index) + '</div>'));
    }

    if (isEmpty($(".result-skills"))) {
        addSkillForm($skillCollection, $newSkill);
    }

    $('button.btn-add-option').on('click', function (e) {
        e.preventDefault();
        addSkillForm($skillCollection, $newSkill);
    });

    $(document).on("click", ".item-block .btn-remove", function (a) {
        a.preventDefault();
        var b = $(this).parents(".item-block").parent("div");
        b.fadeOut(600, function () {
            b.remove();
        });
    });
});
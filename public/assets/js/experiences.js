jQuery(document).ready(function () {
    var $newExperience = $('div.btn-add-experience');
    var $experienceCollection = $('div.experiences');

    $experienceCollection.append($newExperience);
    $experienceCollection.data('index', $experienceCollection.find(':input').length);

    function addExperienceForm($experienceCollection, $newExperience) {
        var index = $experienceCollection.data('index');
        var prototype = $experienceCollection.data('prototype');

        $newExperienceForm = $('<div>' + prototype.replace(/__name__/g, index) + '</div>');
        $newExperienceForm.find('.dropify').dropify();
        $newExperience.before($newExperienceForm);

        $experienceCollection.data('index', index + 1);
    }

    $('button.btn-add-experience').on('click', function (e) {
        e.preventDefault();

        addExperienceForm($experienceCollection, $newExperience);
    });

    $(document).on("click", ".item-block .btn-remove", function (e) {
        e.preventDefault();
        
        $(this).parents(".item-block").parent("div").fadeOut(600, function () {
            $(this).remove();
        });
    });
});
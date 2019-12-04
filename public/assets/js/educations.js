jQuery(document).ready(function () {
    var $newEducation = $('div.btn-add-education');
    var $educationCollection = $('div.educations');

    $educationCollection.append($newEducation);
    $educationCollection.data('index', $educationCollection.find(':input').length);

    function addEducationForm($educationCollection, $newEducation) {
        var index = $educationCollection.data('index');
        var prototype = $educationCollection.data('prototype');

        $newEducationForm = $('<div>' + prototype.replace(/__name__/g, index) + '</div>');
        $newEducationForm.find('.dropify').dropify();
        $newEducation.before($newEducationForm);

        $educationCollection.data('index', index + 1);
    }

    $('button.btn-add-education').on('click', function (e) {
        e.preventDefault();

        addEducationForm($educationCollection, $newEducation);
    });

    $(document).on("click", ".item-block .btn-remove", function (e) {
        e.preventDefault();

        $(this).parents(".item-block").parent("div").fadeOut(600, function () {
            $(this).remove();
        });
    });
});
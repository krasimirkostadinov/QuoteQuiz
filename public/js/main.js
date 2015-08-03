$(document).ready(function () {
    //ajax get quiz by question type - boolean yes/no OR multiple choise
    $(document).on('click', '.quiz-boolean, .quiz-multiple', function (e) {
        e.preventDefault();
        var question_type = $(this).attr("data-id");
        var loader = '<img class="loader-image" src="' + host_path + '/public/images/loader.gif" />';
        $.ajax({
            url: host_path + '/ajax/get_quiz.php',
            type: 'post',
            dataType: 'json',
            data: {question_type: question_type},
            beforeSend: function () {
                $('#tab-two').before(loader);
            }
        }).success(function (result) {
            $('.loader-image').remove();
            $('html, body').animate({
                    scrollTop: $('.solving-quiz').offset().top
            }, 2000);
            if (result.state === true) {
                $('.solving-quiz').html(result.data);
                $('.user-quiz ul li.question:first-child').addClass('visible');
            }
            else {
                $('.solving-quiz').text('<div class="alert alert-danger">No results</div>');
            }
        }).fail(function () {
            $('body').html('Error, please try again.');
        });
    });

    //when user answer, organize funkcionality for load next question
    $(document).on('change', '.user-quiz .question', function () {
        var container = $(this);
        var question_id = container.attr("data-id");
        var user_answer_id = $('input[name=answer-radio]:checked').val();
        var loader = '<img class="loader-image" src="' + host_path + '/public/images/loader.gif" />';

        $.ajax({
            url: host_path + '/ajax/check_multiple_answer.php',
            type: 'post',
            dataType: 'json',
            data: {question_id: question_id, user_answer_id: user_answer_id},
            beforeSend: function () {
                $('.user-quiz .answers').append(loader);
            }
        }).success(function (result) {
            $('.loader-image').remove();
            var current_question = $(".user-quiz .question[data-id='" + question_id + "'] .answers");

            if ($(".user-quiz .question").length > 1) {
                $('.show-next-question').css('display', 'block');
            }

            current_question.remove();
            if (result.state === true) {
                $(".user-quiz .question.visible").append('<p class="alert alert-success">Correct! The right answer is: <strong>' + result.response_answer + '</strong></p>');
            } else {
                $(".user-quiz .question.visible").append('<p class="alert alert-danger">Sorry, you are wrong! The right answer is: <strong>' + result.response_answer + '</strong></p>');
            }
        }).fail(function () {
            $('body').html('Some error');
        });
    });
});

$(document).on('click', '.user-quiz .answer-single-choice', function (e) {
    e.preventDefault();

    var user_answer = $(this).attr("data-id");
    var current_container = $('.single-choice.visible');
    var question_id = current_container.attr("data-id");
    var user_answer_id = current_container.find('.answers-radio').val();
    var loader = '<img class="loader-image" src="' + host_path + '/public/images/loader.gif" />';

    $.ajax({
        url: host_path + '/ajax/check_single_answer.php',
        type: 'post',
        dataType: 'json',
        data: {question_id: question_id, user_answer_id: user_answer_id, user_answer:user_answer},
        beforeSend: function () {
            $('.user-quiz .answers').append(loader);
        }
    }).success(function (result) {
        $('.loader-image').remove();
        var current_question = $(".user-quiz .question[data-id='" + question_id + "'] .answers");

        if ($(".user-quiz .question").length > 1) {
            $('.show-next-question').css('display', 'block');
        }

        current_question.remove();
        if (result.state === true) {
            $(".user-quiz .question.visible").append('<p class="alert alert-success">Correct! The right answer is: <strong>' + result.response_answer + '</strong></p>');
        } else {
            $(".user-quiz .question.visible").append('<p class="alert alert-danger">Sorry, you are wrong! The right answer is: <strong>' + result.response_answer + '</strong></p>');

        }
    }).fail(function () {
        $('body').html('Some error');
    });
});

//click on show next quote
$(document).on('click', '.show-next-question', function (e) {
    e.preventDefault();
    $(this).css('display', 'none');
    $(".user-quiz .question.visible").remove();
    //$('.total-quotes .current-cocunter').html(parseInt($(this).text()));
    var current_quote = parseInt($('.total-quotes .current-cocunter').text());
    $('.total-quotes .current-cocunter').text(current_quote+1);
    var update_value = parseInt($('.total-quotes .current-cocunter').text());
    var total_quotes = parseInt($('.total-quotes .total-cocunter').text());
    //color total quotes counter ON LAST quote
    if(update_value === total_quotes){
        $('.total-quotes').css('color', '#FF0000');
    }
    $('.user-quiz ul li.question:first-child').addClass('visible');
});
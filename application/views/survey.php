<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=$this->about_model->get_by_nama('program')->row()->value;?></title>
<link href="<?php echo base_url('/assets/');?>css/stylesheet.css" type="text/css" rel="stylesheet">
<link href="<?php echo base_url('/assets/');?>css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<!-- Bootstrap 3.3.2 -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/iCheck/all.css') ?>" />
<!-- Font Awesome Icons -->
<link href="<?php echo base_url('assets/font-awesome-4.3.0/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link href="<?php echo base_url('assets/ionicons-2.0.1/css/ionicons.min.css') ?>" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/dist/css/AdminLTE.min.css') ?>" rel="stylesheet" type="text/css" />
<!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/dist/css/skins/_all-skins.min.css') ?>" rel="stylesheet" type="text/css" />
<!-- jQuery 2.1.3 -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jQuery/jQuery-2.1.3.min.js') ?>"></script>
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/iCheck/icheck.min.js') ?>"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/bootstrap/js/bootstrap.min.js') ?>" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/AdminLTE-2.0.5/dist/js/app.min.js') ?>" type="text/javascript"></script>
</head>

<body>
<div id="jquery-script-menu">
<div class="jquery-script-center">
<div class="bg-div">
<div class="logo-img">
	<img src="<?php echo base_url('assets/logofull.jpg');?>" />
</div>
    <nav>
        
	<h1></h1>
    </nav>
</div>

<div class="jquery-script-clear">

</div>
</div>
</div>
<div class="wrapper">
<div class="main">

<div>
  <h1 class="title"><?=$this->about_model->get_by_nama('title')->row()->value;?></h1><br>
  <div class="question-container">
    
</div>
		<div class="overlay">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
        <div class="completed-message"></div>
<div class="row">
	<div class="col-md-8">
		<button id="backBtn" class="btn btn-app"><i class="fa fa-backward"></i>« Kembali</button>
		<button id="homeBtn" class="btn btn-app"><i class="fa fa-home"></i>Home</button>
		<button id="nextBtn" class="btn btn-app"><i class="fa fa-forward"></i>Lanjut »</button>
	</div>
</div>


</div>
</div></div>


<div class="footer">
		<span class="sukma">S U K M A</span><br>
		Kepuasan Masyarakat
</div>
</div>
<script type="text/javascript">

survey = { questions: undefined,
           firstQuestionDisplayed: -1,
           lastQuestionDisplayed: -1};

(function (survey, $) {

    survey.setup_survey = function(questions) {
        var self = this;
        this.questions = questions;

        this.questions.forEach(function(question) {
            self.generateQuestionElement( question );
        });
      
        $('#backBtn').click(function() {
            if ( !$('#backBtn').hasClass('disabled') ) {
                self.showPreviousQuestionSet();
            }
        });
      
        $('#nextBtn').click(function() {
            var ok = true;
            for (i = self.firstQuestionDisplayed; i <= self.lastQuestionDisplayed; i++) {
                if (self.questions[i]['required'] === true && !self.getQuestionAnswer(questions[i])) {
                    $('.question-container > div.question:nth-child(' + (i+1) + ') > .required-message').fadeIn();
                    ok = false;
                }
            }
            if (!ok)
                return

            if ( $('#nextBtn').text().indexOf('Lanjut') === 0 ) {
                self.showNextQuestionSet();
            }
            else {
                var answers = {};
                for (i = 0; i < self.questions.length; i++) {
                    answers[self.questions[i].id] = self.getQuestionAnswer(self.questions[i]);
                }
				var jawaban = {};
				jawaban['answers'] = answers;
				var post_array = {
					"answers" : JSON.stringify(answers),
				} 
                $.ajax({type: 'post',
                        url: '<?php echo base_url('/survey/add');?>',
                        //contentType: "application/json",
                        data: post_array,
                        //processData: false,
						beforeSend: function() {
                            self.hideAllQuestions();
        					$('.overlay').fadeIn();
    					},
                        success: function(response) {
                            self.hideAllQuestions();
                            $('#nextBtn').hide();
                            $('#backBtn').hide();
							$('#homeBtn' ).removeClass('invisible');
							//alert(response);
                            if (response==1) {
                                $('.completed-message').html('Terima kasih atas partisipasinya!');
                            }
                            else if (response==0) {
                                $('.completed-message').text('Maaf sistem terjadi eror, silahkan ulangi lagi');
                            }
                            else {
                                $('.completed-message').text('Maaf sistem terjadi eror, silahkan ulangi lagi');
                            }
							$('.overlay').fadeOut();
                        },
                        error: function(response) {
							//alert(response);
                            self.hideAllQuestions();
                            $('#nextBtn').hide();
                            $('#backBtn').hide();
							$('#homeBtn' ).removeClass('invisible');
                            $('.completed-message').text('Server tidak merespon');
							$('.overlay').fadeOut();
                        }
                });
            }
        });
      
        this.showNextQuestionSet();
         
    }
	
    survey.getQuestionAnswer = function(question) {
        var result;
        if ( question.type === 'single-select' ) {
            result = $('input[type="radio"][name="' + question.id + '"]:checked').val();
        }
        else if ( question.type === 'single-select-oneline' ) {
            result = $('input[type="radio"][name="' + question.id + '"]:checked').val();
        }
        else if ( question.type === 'text-field-small' ) {
            result = $('input[name=' + question.id + ']').val();
        }
        else if ( question.type === 'text-field-large' ) {
            result = $('textarea[name=' + question.id + ']').val();
        }
        return result ? result : undefined;
    }

    survey.generateQuestionElement = function(question) {
        var questionElement = $('<div id="' + question.id + '" class="question"></div>');
        var questionTextElement = $('<div class="question-text"></div>');
        var questionAnswerElement = $('<div class="answer"></div>');
        var questionCommentElement = $('<div class="comment"></div>');
        questionElement.appendTo($('.question-container'));
        questionElement.append(questionTextElement);
        questionElement.append(questionAnswerElement);
        questionElement.append(questionCommentElement);
        questionTextElement.html(question.text);
        questionCommentElement.html(question.comment);
		$('.overlay').hide();
        if ( question.type === 'single-select' ) {
            questionElement.addClass('single-select');
            question.options.forEach(function(option) {
                questionAnswerElement.append('<label class="radio"><input type="radio" class="minimal" value="' + option + '" name="' + question.id + '"/> ' + option + '</label>');
				$('input[type="radio"].minimal').iCheck({
					radioClass   : 'iradio_minimal-blue'
				});
            });
        }
        else if ( question.type === 'single-select-oneline' ) {
            questionElement.addClass('single-select-oneline');
            var html = '<table border="0" cellpadding="5" cellspacing="0"><tr><td></td>';
            question.options.forEach(function(label) {
                html += '<td><label>' + label + '</label></td>';
            });
            html += '<td></td></tr><tr><td><div>' + question.labels[0] + '</div></td>';
            question.options.forEach(function(label) {
                html += '<td><div><input type="radio" value="' + label + '" name="' + question.id + '"></div></td>';
            });
            html += '<td><div>' + question.labels[1] + '</div></td></tr></table>';
            questionAnswerElement.append(html);
			
        }
        else if ( question.type === 'text-field-small' ) {
            questionElement.addClass('text-field-small');
            questionAnswerElement.append('<div class="row"><div class="col-xs-3"><input type="text" value="" class="text form-control" name="' + question.id + '" placeholder="Umur..." id="numpad"/></div></div>');
        }
        else if ( question.type === 'text-field-large' ) {
            questionElement.addClass('text-field-large');
            questionAnswerElement.append('<textarea rows="8" cols="0" class="text form-control" name="' + question.id + '" placeholder="Tuliskan Saran Anda...">');
        }
        if ( question.required === true ) {
            var last = questionTextElement.find(':last');
            (last.length ? last : questionTextElement).append('<span class="required-asterisk" aria-hidden="true">*</span>');
        }
        questionAnswerElement.after('<div class="required-message">Wajib di isi</div>');
        questionElement.hide();
    }

    survey.hideAllQuestions = function() {
        $('.question:visible').each(function(index, element){
            $(element).hide();
        });
        $('.required-message').each(function(index, element){
            $(element).hide();
        });
    }

    survey.showNextQuestionSet = function() {
        this.hideAllQuestions();
        this.firstQuestionDisplayed = this.lastQuestionDisplayed+1;
      
        do {
            this.lastQuestionDisplayed++;  
            $('.question-container > div.question:nth-child(' + (this.lastQuestionDisplayed+1) + ')').fadeIn();
            if ( this.questions[this.lastQuestionDisplayed]['break_after'] === true)
                break;
        } while ( this.lastQuestionDisplayed < this.questions.length-1 );
      
        this.doButtonStates();
    }

    survey.showPreviousQuestionSet = function() {
        this.hideAllQuestions();
        this.lastQuestionDisplayed = this.firstQuestionDisplayed-1;
      
        do {
            this.firstQuestionDisplayed--;  
            $('.question-container > div.question:nth-child(' + (this.firstQuestionDisplayed+1) + ')').fadeIn();
            if ( this.firstQuestionDisplayed > 0 && this.questions[this.firstQuestionDisplayed-1]['break_after'] === true)
                break;
        } while ( this.firstQuestionDisplayed > 0 );
      
        this.doButtonStates();
    }

    survey.doButtonStates = function() {
        if ( this.firstQuestionDisplayed == 0 ) {
            $('#backBtn').addClass('invisible');  
        }
        else if ( $('#backBtn' ).hasClass('invisible') ) {
            $('#backBtn').removeClass('invisible');
        }
        
        if ( this.lastQuestionDisplayed == this.questions.length-1 ) {
            //$('#nextBtn').text('Selesai');
            //$('#nextBtn').addClass('blue'); 
			$('#nextBtn').empty();
			$('#nextBtn').append('<i class="fa fa-save"></i>Selesai');
			
        }
        //else if ( $('#nextBtn').text() === 'Selesai' ) {
		else if ($('#nextBtn').text().indexOf('Selesai') === 0) {
            //$('#nextBtn').text('Lanjut »'); 
            //$('#nextBtn').removeClass('blue');
			$('#nextBtn').empty();
			$('#nextBtn').append('<i class="fa fa-forward"></i>Lanjut »');
        }
    }
})(survey, jQuery);
$(document).ready(function(){
	$('#backBtn' ).addClass('invisible');
	$('#homeBtn' ).addClass('invisible');
	/*
    $.getJSON('<?php echo base_url('/survey/pertanyaan');?>', function(json) {
        survey.setup_survey(json);        
    });
	*/
	var json = <?php echo $pertanyaan;?>;
	survey.setup_survey(json);
	$('input[type="radio"].minimal').iCheck({
      radioClass   : 'iradio_minimal-blue'
    });
	$('#homeBtn').click(function() {
            window.location.reload();
    });
});
</script>
</body>
</html>

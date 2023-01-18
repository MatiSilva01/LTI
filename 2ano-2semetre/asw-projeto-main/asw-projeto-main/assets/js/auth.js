$('#signup').click(function () {
  $('#first').fadeOut('fast', function () {
    $('#second').fadeIn('fast');
  });
});

$('#signin').click(function () {
  $('#second').fadeOut('fast', function () {
    $('#first').fadeIn('fast');
  });
});

$('form[name="login"]').validate({
  rules: {
    usernameEmailLogin: {
      required: true,
    },
    passwordLogin: {
      required: true,
      minlength: 5
    }
  },
  messages: {
    usernameEmailLogin: 'Por favor insira um email válido',
    passwordLogin: {
      required: 'Por favor insira uma senha válida',
      minlength: 'A senha tem de ter pelo menos 5 caracteres'
    }
  },
  submitHandler: function (form) {
    form.submit();
  }
});


$('form[name="registerVoluntario"]').validate({
  rules: {
    nomeVoluntario: {
      required: true,
      minlength: 5
    },
    emailVoluntario: {
      required: true,
      email: true
    },
    passwordVoluntario: {
      required: true,
      minlength: 5
    },
    confirmPasswordVoluntario: {
      required: true,
      minlength: 5,
      equalTo: '#passwordVoluntario'
    },
    dataNascimentoVoluntario: {
      required: true,
      dateISO: true
    },
    generoVoluntario: 'required',
    imagemVoluntario: 'required',
    telefoneVoluntario: 'required',
    cartaoCidadaoVoluntario: 'required',
    cartaConducaoVoluntario: 'required',
    distritoVoluntario: 'required',
    concelhoVoluntario: 'required',
    freguesiaVoluntario: 'required',
  },

  messages: {
    nomeVoluntario: {
      required: 'Por favor insira um nome de utilizador',
      minlength: 'O nome tem de ter pelo menos 5 caracteres'
    },
    emailVoluntario: {
      required: 'Por favor insira um email',
      email: 'Por favor insira um email válido',
    },
    passwordVoluntario: {
      required: 'Por favor insira uma senha',
      minlength: 'A senha tem de ter pelo menos 5 caracteres'
    },
    confirmPasswordVoluntario: {
      required: 'Por favor insira uma senha',
      minlength: 'A senha tem de ter pelo menos 5 caracteres',
      equalTo: 'As senhas devem ser iguais'
    },
    dataNascimentoVoluntario: {
      required: 'Por favor insira uma data de nascimento',
      dateISO: 'Deve ser uma data válida'
    },
    generoVoluntario: 'Por favor seleccione um género',
    imagemVoluntario: 'Por favor adicione uma imagem',
    telefoneVoluntario: 'Por favor insira um número de telefone',
    cartaoCidadaoVoluntario: 'Por favor insira o número de cartão de cidadão',
    cartaConducaoVoluntario: 'Por favor insira o número de carta de condução',
    distritoVoluntario: 'Por favor seleccione um distrito',
    concelhoVoluntario: 'Por favor seleccione um concelho',
    freguesiaVoluntario: 'Por favor seleccione um freguesia',
  },

  submitHandler: function (form) {
    form.submit();
  }
});

// TODO validate registerInstituicao
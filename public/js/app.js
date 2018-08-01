/* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
particlesJS.load('particles-js', '/public/json/particle.json', function() {
  console.log('callback - particles.js config loaded');
});

$(function() {
  $('.b_about').click(function() {
    $('.page').removeClass('addreg');
    $('.page').removeClass('addinfo');
    $('.page').removeClass('addauth');
    $('.page').toggleClass('addabout');

    return false;
  });

  $('.b_info').click(function() {
    $('.d1').removeClass('d1_on d_on');
    $('.d2').removeClass('d2_on d_on');
    $('.d3').removeClass('d3_on d_on');
    $('.t1').removeClass('t1_on t_on');
    $('.t2').removeClass('t2_on t_on');
    $('.t3').removeClass('t3_on t_on');
    $('.page').removeClass('addabout');
    $('.page').removeClass('addauth');
    $('.page').removeClass('addreg');
    $('.page').toggleClass('addinfo');
    $('.d1').toggleClass('d1_on d_on');
    $('.d2').toggleClass('d2_on  d_on');
    $('.d3').toggleClass('d3_on  d_on');
    $('.t1').toggleClass('t1_on t_on');
    $('.t2').toggleClass('t2_on t_on');
    $('.t3').toggleClass('t3_on t_on');

    return false;
  });

  $('.b_auth').click(function() {
    $('.page').removeClass('addabout');
    $('.page').removeClass('addinfo');
    $('.page').removeClass('addreg');
    $('.page').toggleClass('addauth');

    return false;
  });

  $('.b_reg').click(function() {
    $('.page').removeClass('addabout');
    $('.page').removeClass('addinfo');
    $('.page').removeClass('addauth');
    $('.page').toggleClass('addreg');

    return false;
  });

  $('.m_about').click(function() {
    $('.page').removeClass('addabout');

    return false;
  });

  $('.m_info').click(function() {
    $('.page').removeClass('addinfo');
    $('.d1').removeClass('d1_on d_on');
    $('.d2').removeClass('d2_on d_on');
    $('.d3').removeClass('d3_on d_on');
    $('.t1').removeClass('t1_on t_on');
    $('.t2').removeClass('t2_on t_on');
    $('.t3').removeClass('t3_on t_on');

    return false;
  });
/*
  $('.m_auth').click(function(e) {
    if (e.target !== this) return false;
    $('.page').removeClass('addauth');

    return false;
  });

  $('.m_reg').click(function(e) {
    if (e.target !== this) return false;
    $('.page').removeClass('addreg');

    return false;
  });
*/
});

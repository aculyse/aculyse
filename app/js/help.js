function loadHelpSection(a){$("#content-container").load(a);$("#help-nav a").removeClass("active");switch(a){case"help_views/security_tips.php":$("#help-nav #sec").addClass("active");break;case"help_views/profiling_tips.php":$("#help-nav #prof").addClass("active");break;case"help_views/report_tips.php":$("#help-nav #err").addClass("active");break}};
/*Size: 431->351Bytes 
 Saved 18.561481%*/
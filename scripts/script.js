


var burger = document.querySelector(".burger");

burger.addEventListener('click',function(){
	"use strict";

	var nav = document.querySelector(".nav-links");

	nav.classList.toggle("nav-active");

});

var show_all = document.querySelector(".show-all");
var show_inside = document.querySelector(".show-inside");
var show_outside = document.querySelector(".show-outside");


var filter = document.querySelector("#filter");

filter.addEventListener("change", function(){
	
	
	"use strict";
	
	if(filter.value === 'inside_services'){
		show_all.classList.add("hide");
		show_inside.classList.remove("hide");
		show_outside.classList.add("hide");
	}
	if(filter.value === 'outside_services'){
		show_all.classList.add("hide");
		show_inside.classList.add("hide");
		show_outside.classList.remove("hide");
	}
	if(filter.value === 'all_services'){
		show_all.classList.remove("hide");
		show_inside.classList.add("hide");
		show_outside.classList.add("hide");
	}

});













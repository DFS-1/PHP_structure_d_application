const burger = document.querySelector("#burger");
const navUl = document.querySelector("header nav ul");
const burgerIcons = document.querySelectorAll(".burgerIcon");

burger.addEventListener("click", function () {
	navUl.classList.toggle("visible");
	burgerIcons.forEach((icon) => {
		icon.classList.toggle("burgerVisible");
	});
});

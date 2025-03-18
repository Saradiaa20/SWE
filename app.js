const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");
sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});
sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});

// const signUpButton = document.getElementById('sign-up-btn');
// const signInButton = document.getElementById('sign-in-btn');


// signUpButton.addEventListener('click', () => {
//     container.classList.add('sign-up-mode');
// });

// signInButton.addEventListener('click', () => {
//     container.classList.remove('sign-up-mode');
// });
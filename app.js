const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");
sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});
sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});

document.addEventListener('DOMContentLoaded', function () {
  console.log("JavaScript is running!"); // Add this line
  const searchIcon = document.getElementById('search-icon');
  const searchForm = document.getElementById('search-form');

  searchIcon.addEventListener('click', function (event) {
      console.log("Search icon clicked!"); // Add this line
      event.stopPropagation();
      searchForm.classList.toggle('active');
  });

  document.addEventListener('click', function (event) {
      if (!searchForm.contains(event.target)) {
          searchForm.classList.remove('active');
      }
  });
});
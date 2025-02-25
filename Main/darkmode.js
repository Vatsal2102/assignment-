// document.addEventListener("DOMContentLoaded", () => {
//     const darkModeToggle = document.getElementById("darkModeToggle");
//     const body = document.body;

//     darkModeToggle.addEventListener("click", () => {
//         fetch("dark-mode.php", {
//             method: "POST",
//             headers: { "Content-Type": "application/x-www-form-urlencoded" },
//             body: "toggleDarkMode=true"
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.darkMode === "enabled") {
//                 body.classList.add("dark-mode");
//                 darkModeToggle.textContent = "☀️ Light Mode";
//             } else {
//                 body.classList.remove("dark-mode");
//                 darkModeToggle.textContent = "🌙 Dark Mode";
//             }
//         })
//         .catch(error => console.error("Error:", error));
//     });
// });

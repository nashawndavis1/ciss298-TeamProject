function loadPage(page) {
  const extension = page.endsWith(".php") ? "php" : "html";
  const pageName = page.replace(/\.(php|html)$/, "");
  const fullFile = `${pageName}.${extension}`;

  // Determine fetch target
  const fetchUrl = extension === "php"
    ? `load.php?page=${pageName}`
    : `pages/${fullFile}`;

  fetch(fetchUrl)
    .then(response => {
      if (!response.ok) {
        throw new Error("Page not found");
      }
      return response.text();
    })
    .then(data => {
      document.getElementById("content-container").innerHTML = data;
      history.pushState(null, "", `?page=${fullFile}`);
    })
    .catch(error => {
      console.error(`Error loading ${pageName}:`, error);
      document.getElementById("content-container").innerHTML = "<h1>404 Not Found</h1>";
    });
}

window.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);
  const queryPage = params.get("page") || "home"; // Default to home if no ?page=
  loadPage(queryPage);
});

window.addEventListener("popstate", () => {
  const params = new URLSearchParams(window.location.search);
  const queryPage = params.get("page") || "home";
  loadPage(queryPage);
});

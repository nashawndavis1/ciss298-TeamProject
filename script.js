function loadPage(page) {
  const extension = page.endsWith(".php") ? "php" : "html";
  const pageName = page.replace(/\.(php|html)$/, "");
  const fullFile = `${pageName}.${extension}`;

  // Determine fetch target for the main page
  const fetchUrl = extension === "php"
    ? `load.php?page=${pageName}`
    : `pages/${fullFile}`;

  fetch(fetchUrl)
    .then(response => {
      if (!response.ok) throw new Error("Page not found");
      return response.text();
    })
    .then(data => {
      document.getElementById("content-container").innerHTML = data;
      history.pushState(null, "", `?page=${fullFile}`);

      loadAside(pageName);
    })
    .catch(error => {
      console.error(`Error loading ${pageName}:`, error);
      document.getElementById("content-container").innerHTML = "<h1>404 Not Found</h1>";
    });
}

function loadAside(page) {
  const asideContainer = document.getElementById("aside-container");
  const excludedPages = ["test", "test2",];
  const normalizedPage = page.replace(/\.(php|html)$/, "");

  if (!excludedPages.includes(normalizedPage)) {
    // Show and load aside if not excluded
    if (!asideContainer.dataset.loaded) {
      fetch("load.php?page=aside")
        .then(response => response.text())
        .then(data => {
          asideContainer.innerHTML = data;
          asideContainer.classList.remove("d-none");
          asideContainer.dataset.loaded = "true";
          attachAvailabilityFormHandler();
        })
        .catch(error => console.error("Error loading aside:", error));
    } else {
      asideContainer.classList.remove("d-none");
      attachAvailabilityFormHandler();
    }
  } else {
    asideContainer.classList.add("d-none");
  }
}

// Handle refreshes
window.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);
  const queryPage = params.get("page") || "home";
  loadPage(queryPage);
});

window.addEventListener("popstate", () => {
  const params = new URLSearchParams(window.location.search);
  const queryPage = params.get("page") || "home";
  loadPage(queryPage);
});

function attachAvailabilityFormHandler() {
  console.log("Binding availability form");
  const form = document.getElementById("availability-form");
  if (!form) return;

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch("checkAvailability.php", {
      method: "POST",
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        const div = document.getElementById("availability-result");
        div.innerHTML = `<p>${data.message}</p>`;

        if (data.available) {
          const btn = document.createElement("button");
          btn.className = "btn btn-primary btn-sm mt-2";
          btn.innerText = "Reserve Now";
          btn.onclick = () => loadPage("reservation.php");
          div.appendChild(btn);
        }
      })
      .catch(err => {
        console.error(err);
        document.getElementById("availability-result").innerText = "An error occurred.";
      });
  });
}


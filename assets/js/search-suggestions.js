function initSearchSuggestions(inputSelector, suggestionsSelector) {
    const searchInput = document.querySelector(inputSelector);
    const suggestionsBox = document.querySelector(suggestionsSelector);

    if (!searchInput || !suggestionsBox) return;

    let timeout;

    searchInput.addEventListener("input", () => {
        clearTimeout(timeout);
        const query = searchInput.value.trim();

        if (query.length === 0) {
            suggestionsBox.innerHTML = "";
            suggestionsBox.style.display = "none";
            return;
        }

        timeout = setTimeout(() => {
            fetch(`../ajax/search-suggestions.php?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    suggestionsBox.innerHTML = "";
                    if (data.length === 0) {
                        suggestionsBox.style.display = "none";
                        return;
                    }

                    data.forEach(item => {
                        const div = document.createElement("div");
                        div.textContent = item;
                        div.classList.add("suggestion-item");
                        div.addEventListener("click", () => {
                            searchInput.value = item;
                            suggestionsBox.innerHTML = "";
                            suggestionsBox.style.display = "none";
                            // Redirect to products.php with search parameter
                            window.location.href = `../pages/products.php?q=${encodeURIComponent(item)}`;
                        });
                        suggestionsBox.appendChild(div);
                    });

                    suggestionsBox.style.display = "flex";
                })
                .catch(err => {
                    console.error('Search suggestions error:', err);
                    suggestionsBox.innerHTML = "";
                    suggestionsBox.style.display = "none";
                });
        }, 300);
    });

    searchInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            const query = searchInput.value.trim();
            if (query.length > 0) {
                window.location.href = `../pages/products.php?q=${encodeURIComponent(query)}`;
            }
        }
    });
    // Hide suggestions when clicking outside
    document.addEventListener("click", (e) => {
        if (!suggestionsBox.contains(e.target) && e.target !== searchInput) {
            suggestionsBox.style.display = "none";
        }
    });
    suggestionsBox.addEventListener("click", (e) => {
        e.stopPropagation();
    });
}

// Auto-initialize depending on which page structure exists
document.addEventListener("DOMContentLoaded", () => {
    if (document.querySelector("#search-input") && document.querySelector(".search-suggestions")) {

        initSearchSuggestions("#search-input", ".search-suggestions");
    } else if (document.querySelector("#searchInput") && document.querySelector("#suggestionsBox")) {

        initSearchSuggestions("#searchInput", "#suggestionsBox");
    }
});

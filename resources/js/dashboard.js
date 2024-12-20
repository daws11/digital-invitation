document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.getElementById("search-form");
    const searchInput = document.getElementById("search-input");
    const tableBody = document.querySelector("#guests-table tbody");
    if (!searchForm || !searchInput || !tableBody) {
        return;
    }
    searchForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Cegah refresh halaman

        const query = searchInput.value;

        // Kirim permintaan AJAX
        fetch(`/api/guests?search=${encodeURIComponent(query)}`, {
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                console.log(data);
                // Kosongkan tabel
                tableBody.innerHTML = "";

                // Tambahkan data baru ke tabel
                data.guests.forEach((guest) => {
                    const row = `
                         <tr class="border-b hover:bg-primary-light/50 transition-colors duration-200">
                            <td class="py-2 px-4 text-primary-dark">${
                                guest.name
                            }</td>
                            <td class="py-2 px-4 flex justify-center">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full ${
                                    guest.will_attend
                                        ? "bg-primary-light text-primary"
                                        : "bg-gray-100 text-gray-600"
                                }">
                                    ${guest.will_attend ? "Hadir" : "Tidak"}
                                </span>
                            </td>
                            <td class="py-2 px-4 text-primary-dark">${
                                guest.number_of_guests ?? "-"
                            }</td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            })
            .catch((error) => console.error("Error:", error));
    });
});

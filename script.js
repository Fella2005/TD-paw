// Ajouter un étudiant dynamiquement
function addStudentToTable(student) {
    const table = document.getElementById('attendanceTable').getElementsByTagName('tbody')[0];
    const newRow = table.insertRow();
    newRow.innerHTML = `
        <td>${student.id}</td>
        <td>${student.name}</td>
        <td>${student.group}</td>
        <td><input type="checkbox" class="present"></td>
        <td><input type="checkbox" class="participation"></td>
        <td contenteditable="true"></td>
    `;
}

// Mettre à jour le message et la couleur selon absences/participation
function updateMessages() {
    const table = document.getElementById('attendanceTable');
    for (let i = 1; i < table.rows.length; i++) {
        const row = table.rows[i];
        const present = row.querySelector(".present").checked;
        const participation = row.querySelector(".participation").checked;
        const messageCell = row.cells[5];

        if (present && participation) {
            row.style.backgroundColor = "#c8e6c9"; // vert
            messageCell.textContent = "Bonne présence et participation";
        } else if (!present && participation) {
            row.style.backgroundColor = "#fff9c4"; // jaune
            messageCell.textContent = "Attention : Absence mais participation";
        } else if (!present && !participation) {
            row.style.backgroundColor = "#ffcdd2"; // rouge
            messageCell.textContent = "Exclu : trop d’absences";
        } else {
            row.style.backgroundColor = "";
            messageCell.textContent = "";
        }
    }
}

// Formulaire ajout étudiant
function addStudent(event) {
    event.preventDefault();

    const id = document.getElementById("studentID").value.trim();
    const name = document.getElementById("studentName").value.trim();
    const group = document.getElementById("studentGroup").value.trim();

    if (!id || !name || !group) {
        alert("Tous les champs sont obligatoires !");
        return;
    }

    addStudentToTable({id, name, group});
    document.getElementById("studentForm").reset();
}

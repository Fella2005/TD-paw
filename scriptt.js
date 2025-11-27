// Étudiants initiaux ou chargés depuis localStorage
let students = JSON.parse(localStorage.getItem('students')) || [
  {id:'1001', last:'Sara', first:'Ahmed', email:'sara@example.com', course:'Advanced Web Programming', sessions:[true,false,true,false,true,false], participation:[true,true,false,true,false,false], message:''},
  {id:'1002', last:'Yacine', first:'Ali', email:'yacine@example.com', course:'Advanced Web Programming', sessions:[true,true,false,true,false,true], participation:[true,false,true,true,false,true], message:''},
  {id:'1003', last:'Rania', first:'Kacem', email:'rania@example.com', course:'Advanced Web Programming', sessions:[true,false,true,true,true,false], participation:[false,true,true,true,false,true], message:''}
];

// Afficher le tableau
function renderTable() {
  const tbody = document.getElementById("attendanceTable").getElementsByTagName('tbody')[0];
  tbody.innerHTML = "";
  students.forEach((s, index) => {
    const row = tbody.insertRow();
    let sessionHtml = '';
    for (let i = 0; i < 6; i++) {
      sessionHtml += `<td><input type="checkbox" class="session" data-index="${i}" ${s.sessions[i] ? 'checked' : ''}></td>`;
      sessionHtml += `<td><input type="checkbox" class="participation" data-index="${i}" ${s.participation[i] ? 'checked' : ''}></td>`;
    }
    row.innerHTML = `
      <td>${s.id}</td>
      <td>${s.last} ${s.first}</td>
      <td>${s.course}</td>
      ${sessionHtml}
      <td></td> <!-- Absences -->
      <td></td> <!-- Participation -->
      <td contenteditable="true">${s.message}</td>
      <td><button onclick="deleteStudent(${index})">Supprimer</button></td>
    `;
  });
  updateTable();
}

// Ajouter un étudiant
function addStudent(event) {
  event.preventDefault();
  const id = document.getElementById("studentID").value.trim();
  const last = document.getElementById("lastName").value.trim();
  const first = document.getElementById("firstName").value.trim();
  const email = document.getElementById("email").value.trim();
  const course = document.getElementById("course").value.trim();

  let valid = true;
  document.getElementById("idError").textContent = "";
  document.getElementById("lastNameError").textContent = "";
  document.getElementById("firstNameError").textContent = "";
  document.getElementById("emailError").textContent = "";
  document.getElementById("courseError").textContent = "";

  if(!id || !/^\d+$/.test(id)) {document.getElementById("idError").textContent = "ID doit être un nombre"; valid=false;}
  if(!last || !/^[A-Za-z]+$/.test(last)) {document.getElementById("lastNameError").textContent = "Nom invalide"; valid=false;}
  if(!first || !/^[A-Za-z]+$/.test(first)) {document.getElementById("firstNameError").textContent = "Prénom invalide"; valid=false;}
  if(!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {document.getElementById("emailError").textContent = "Email invalide"; valid=false;}
  if(!course) {document.getElementById("courseError").textContent = "Course obligatoire"; valid=false;}
  if(!valid) return false;

  students.push({id, last, first, email, course, sessions:[false,false,false,false,false,false], participation:[false,false,false,false,false,false], message:''});
  saveStudents();
  renderTable();
  document.getElementById("studentForm").reset();
}

// Supprimer un étudiant
function deleteStudent(index){
  if(confirm("Voulez-vous vraiment supprimer cet étudiant ?")){
    students.splice(index,1);
    saveStudents();
    renderTable();
  }
}

// Mettre à jour messages, compteurs et couleurs
function updateTable(){
  const tbody = document.getElementById("attendanceTable").getElementsByTagName('tbody')[0];
  Array.from(tbody.rows).forEach((row,index)=>{
    let absences = 0, participations = 0;
    const sCheckboxes = row.querySelectorAll(".session");
    const pCheckboxes = row.querySelectorAll(".participation");
    sCheckboxes.forEach(cb=>{if(!cb.checked) absences++;});
    pCheckboxes.forEach(cb=>{if(cb.checked) participations++;});

    // Couleur
    if(absences <3) row.style.backgroundColor = "#c8e6c9"; // vert
    else if(absences <=4) row.style.backgroundColor = "#fff9c4"; // jaune
    else row.style.backgroundColor = "#ffcdd2"; // rouge

    // Compteurs corrects
    row.cells[15].textContent = absences;
    row.cells[16].textContent = participations;

    // Message automatique
    let msg='';
    if(absences<3 && participations>=4) msg="Good attendance – Excellent participation";
    else if(absences>=3 && absences<5) msg="Warning – attendance low – You need to participate more";
    else if(absences>=5) msg="Excluded – too many absences – You need to participate more";
    row.cells[17].textContent=msg;

    // Mise à jour students
    students[index].sessions = Array.from(sCheckboxes).map(cb=>cb.checked);
    students[index].participation = Array.from(pCheckboxes).map(cb=>cb.checked);
    students[index].message = msg;
  });
  saveStudents();
}

// Sauvegarder dans localStorage
function saveStudents(){
  localStorage.setItem('students',JSON.stringify(students));
}

// Initialiser
renderTable();

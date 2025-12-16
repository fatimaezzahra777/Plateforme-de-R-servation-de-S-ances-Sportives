let selectedRole = 'athlete';

        function showPage(pageId) {
            document.querySelectorAll('.page').forEach(page => {
                page.classList.remove('active');
            });
            document.getElementById(pageId).classList.add('active');
            window.scrollTo(0, 0);
        }

        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }

        function selectRole(role) {
            selectedRole = role;
            document.getElementById('athleteBtn').classList.remove('bg-blue-50', 'border-blue-600', 'text-blue-600');
            document.getElementById('coachBtn').classList.remove('bg-blue-50', 'border-blue-600', 'text-blue-600');

            if (role === 'athlete') {
                document.getElementById('athleteBtn').classList.add('bg-blue-50', 'border-blue-600', 'text-blue-600');
            } else {
                document.getElementById('coachBtn').classList.add('bg-blue-50', 'border-blue-600', 'text-blue-600');
            }
        }

        function handleLogin(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'success',
                title: 'Connexion réussie',
                text: 'Bienvenue sur SportCoach',
                confirmButtonColor: '#2563eb'
            });

            if (selectedRole === 'coach') {
                showPage('coach-dashboard');
            } else {
                showPage('athlete-dashboard');
            }
        }

        function handleRegister(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'success',
                title: 'Compte créé',
                text: 'Votre compte a été créé avec succès',
                confirmButtonColor: '#2563eb'
            });

            if (selectedRole === 'coach') {
                showPage('coach-dashboard');
            } else {
                showPage('athlete-dashboard');
            }
        }

        // Données fictives coachs
        const coaches = [
            { name: "Ahmed Benali", sport: "Football", city: "Casablanca", price: "300 DH" },
            { name: "Sara El Amrani", sport: "Tennis", city: "Rabat", price: "400 DH" },
            { name: "Youssef Karim", sport: "Natation", city: "Marrakech", price: "350 DH" },
        ];

        function loadCoaches() {
            const list = document.getElementById('coachesList');
            if (!list) return;

            list.innerHTML = '';
            coaches.forEach(c => {
                list.innerHTML += `
                    <div class="bg-white rounded-xl shadow-lg p-6 hover-scale">
                        <h3 class="text-xl font-bold mb-2">${c.name}</h3>
                        <p class="text-gray-600">${c.sport}</p>
                        <p class="text-gray-500">${c.city}</p>
                        <p class="font-bold text-blue-600 mt-2">${c.price}</p>
                        <button class="mt-4 w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                            Réserver
                        </button>
                    </div>
                `;
            });
        }

        document.addEventListener('DOMContentLoaded', loadCoaches);
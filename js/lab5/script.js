document.addEventListener('DOMContentLoaded', () => {
    // Компонент тоста
    const toastContainer = document.getElementById('toast-container');
    
    function showToast(message, isError = false) {
        const toast = document.createElement('div');
        toast.className = `toast ${isError ? 'toast-error' : 'toast-success'}`;
        
        const messageSpan = document.createElement('span');
        messageSpan.textContent = message;
        
        const closeButton = document.createElement('button');
        closeButton.className = 'toast-close';
        closeButton.textContent = '×';
        closeButton.setAttribute('aria-label', 'Закрыть уведомление');
        
        toast.appendChild(messageSpan);
        toast.appendChild(closeButton);
        toastContainer.appendChild(toast);
        
        // Анимация появления
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);
        
        closeButton.addEventListener('click', () => {
            toast.classList.remove('show');
            setTimeout(() => {
                toastContainer.removeChild(toast);
            }, 300);
        });
    }
    
    // Переключение темы
    const themeToggle = document.getElementById('theme-toggle');
    
    themeToggle.addEventListener('click', () => {
        document.documentElement.classList.toggle('dark-theme');
        
        const isDarkTheme = document.documentElement.classList.contains('dark-theme');
        localStorage.setItem('theme', isDarkTheme ? 'dark' : 'light');
    });

    // Обновление текста кнопки в зависимости от темы
    function updateThemeButtonText() {
        const isDarkTheme = document.documentElement.classList.contains('dark-theme');
        themeToggle.textContent = isDarkTheme ? 'Светлая тема' : 'Темная тема';
    }
    
    updateThemeButtonText();
    themeToggle.addEventListener('click', updateThemeButtonText);
    
    // Галерея
    const galleryContainer = document.getElementById('gallery-container');
    const refreshButton = document.getElementById('refresh-gallery');
    
    async function fetchGalleryImages(retryCount = 0) {
        galleryContainer.innerHTML = '<div class="loader">Загрузка...</div>';
        
        try {
            const response = await fetch('http://194.67.93.117/images');
            
            if (!response.ok) {
                throw new Error('Не удалось загрузить изображения');
            }
            
            const data = await response.json();
            
            if (data.length === 0) {
                galleryContainer.innerHTML = '<p>Изображения не найдены</p>';
                return;
            }
            
            renderGallery(data);
        } catch (error) {
            if (retryCount < 3) {
                setTimeout(() => {
                    fetchGalleryImages(retryCount + 1);
                }, 1000);
            } else {
                galleryContainer.innerHTML = '';
                showToast('Не удалось загрузить галерею. Попробуйте позже.', true);
            }
        }
    }
    
    function renderGallery(images) {
        galleryContainer.innerHTML = '';
        const gallery = document.createElement('div');
        gallery.className = 'gallery';
        
        images.forEach(image => {
            const card = document.createElement('div');
            card.className = 'gallery-card';
            
            const img = document.createElement('img');
            img.src = image.url; 
            img.alt = image.alt || 'Изображение галереи';
            
            const title = document.createElement('p');
            title.textContent = image.description || 'Без описания';
            
            card.appendChild(img);
            card.appendChild(title);
            gallery.appendChild(card);
        });
        
        galleryContainer.appendChild(gallery);
    }
    
    // Запуск загрузки галереи при загрузке страницы
    fetchGalleryImages();
    
    // Обновление галереи по кнопке
    refreshButton.addEventListener('click', () => {
        fetchGalleryImages();
    });
    
    // Форма отправки температуры
    const temperatureForm = document.getElementById('temperature-form');
    
    temperatureForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const roomInput = document.getElementById('room');
        const temperatureInput = document.getElementById('temperature');
        
        const room = roomInput.value.trim();
        const temperature = parseFloat(temperatureInput.value);
        
        // Блокировка формы на время отправки
        const submitButton = temperatureForm.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        
        try {
            const response = await fetch('http://194.67.93.117/temp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'accept': 'application/json'
                },
                body: JSON.stringify({
                    class: room,
                    temp: temperature
                })
            });
            
            if (!response.ok) {
                throw new Error('Ошибка отправки данных');
            }
            
            const data = await response.json();
            
            if (data.status === 'ok') {
                showToast(data.message || 'Данные успешно отправлены');
                temperatureForm.reset();
            } else {
                showToast(data.message || 'Ошибка при отправке данных', true);
            }
        } catch (error) {
            showToast('Ошибка при отправке данных. Попробуйте снова.', true);
        } finally {
            submitButton.disabled = false;
        }
    });
});
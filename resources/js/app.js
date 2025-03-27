import './bootstrap';

import Alpine from 'alpinejs';

import 'trix';

import 'trix/dist/trix.css';

window.Alpine = Alpine;

Alpine.start();

document.querySelectorAll('.like-btn').forEach(button => {
    button.addEventListener('click', async () => {
        const postId = button.dataset.post;
        const response = await fetch(`/posts/${postId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        button.querySelector('.count').textContent = data.count;
        button.style.color = data.isLiked ? 'red' : 'gray';
    });
});
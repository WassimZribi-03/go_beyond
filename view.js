const BlogView = {
    renderBlogs(blogs) {
        const blogList = document.getElementById("blog-list");
        blogList.innerHTML = "";

        blogs.forEach(blog => {
            const blogDiv = document.createElement("div");
            blogDiv.className = "blog-item";

            blogDiv.innerHTML = `
                <div class="three-dots" onclick="BlogController.toggleMenu(${blog.id})">...</div>
                <div class="action-menu" id="menu-${blog.id}">
                    <button onclick="BlogController.editBlog(${blog.id})">Modifier</button>
                    <button onclick="BlogController.deleteBlog(${blog.id})">Supprimer</button>
                </div>
                <h3>${blog.title}</h3>
                <p>${blog.content}</p>
                <p class="date-publication">Publié le: ${blog.date}</p>  
                <p class="visibility">Visibilité: ${blog.visibility === 'public' ? 'Tout le monde' : 'Moi uniquement'}</p>
                <div class="comments">
                    <h4>Commentaires</h4>
                    <textarea placeholder="Ajouter un commentaire..." id="comment-${blog.id}"></textarea>
                    <button onclick="BlogController.addComment(${blog.id})">Commenter</button>
                    <div id="comments-list-${blog.id}">
                        ${blog.comments.map(comment => `<p>${comment}</p>`).join('')}
                    </div>
                </div>
            `;
            blogList.appendChild(blogDiv);
        });
    },
};

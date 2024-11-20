const BlogController = {
    init() {
        const form = document.getElementById("blog-form");
        form.addEventListener("submit", this.handleFormSubmit);

        this.displayBlogs();
    },

    handleFormSubmit(event) {
        event.preventDefault();

        const title = document.getElementById("blog-title").value;
        const content = document.getElementById("blog-content").value;
        const visibility = document.getElementById("blog-visibility").value;
        const blogId = document.getElementById("blog-id").value;

        if (blogId) {
            BlogModel.editBlog(parseInt(blogId), { title, content, visibility });
            document.getElementById("blog-id").value = "";
        } else {
            BlogModel.addBlog(title, content, visibility);
        }

        document.getElementById("blog-title").value = "";
        document.getElementById("blog-content").value = "";
        document.getElementById("blog-visibility").value = "public";

        this.displayBlogs();
    },

    displayBlogs() {
        const blogs = BlogModel.getBlogs();
        BlogView.renderBlogs(blogs);
    },

    toggleMenu(blogId) {
        const menu = document.getElementById(`menu-${blogId}`);
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    },

    editBlog(id) {
        const blog = BlogModel.blogs.find(blog => blog.id === id);
        document.getElementById("blog-title").value = blog.title;
        document.getElementById("blog-content").value = blog.content;
        document.getElementById("blog-visibility").value = blog.visibility;
        document.getElementById("blog-id").value = blog.id;
        this.toggleMenu(id);
    },

    deleteBlog(id) {
        BlogModel.deleteBlog(id);
        this.displayBlogs();
    },

    addComment(blogId) {
        const commentInput = document.getElementById(`comment-${blogId}`);
        const commentText = commentInput.value;
        if (commentText) {
            BlogModel.addComment(blogId, commentText);
            commentInput.value = "";
            this.displayBlogs();
        }
    },
};

BlogController.init();

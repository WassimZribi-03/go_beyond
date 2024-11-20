const BlogModel = {
    blogs: [],

    addBlog(title, content, visibility) {
        const date = new Date().toISOString().split('T')[0];
        const newBlog = {
            id: Date.now(),
            title,
            content,
            date,
            visibility,
            comments: [],
        };
        this.blogs.push(newBlog);
    },

    editBlog(id, updatedBlog) {
        const blog = this.blogs.find(blog => blog.id === id);
        if (blog) {
            Object.assign(blog, updatedBlog);
        }
    },

    deleteBlog(id) {
        this.blogs = this.blogs.filter(blog => blog.id !== id);
    },

    addComment(blogId, comment) {
        const blog = this.blogs.find(blog => blog.id === blogId);
        if (blog) {
            blog.comments.push(comment);
        }
    },

    getBlogs() {
        return this.blogs;
    },
};

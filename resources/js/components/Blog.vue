<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form @submit="formSubmit" enctype="multipart/form-data">
                        <strong>Name:</strong>
                        <input
                            type="text"
                            class="form-control"
                            v-model="newBlog.title"
                        />
                        <input
                            type="text"
                            class="form-control"
                            v-model="newBlog.description"
                        />
                        <strong>Image:</strong>
                        <input
                            type="file"
                            class="form-control"
                            v-on:change="onImageChange"
                        />

                        <button class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">All Blogs</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="blog in blogs" :key="blog.id">
                                <th scope="row">{{ blog.id }}</th>
                                <td>{{ blog.image }}</td>
                                <td>{{ blog.title }}</td>
                                <td>{{ blog.description }}</td>
                                <td>
                                    <button
                                        @click="editItem(blog)"
                                        class="btn btn-info btn-sm"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        @click="deleteItem(blog.id)"
                                        class="btn btn-danger btn-sm"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            blogs: [],
            newBlog: {
                id: 0,
                title: "",
                description: "",
                image: ""
            },
            error: false
        };
    },
    mounted() {
        console.log("Component mounted.");
    },
    methods: {
        onImageChange(e) {
            console.log(e.target.files[0]);
            this.newBlog.image = e.target.files[0];
        },
        getUser() {
            axios.get("/api/blog").then(response => {
                this.blogs = response.data;
                console.log(this.blogs);
            });
        },
        formSubmit(e) {
            e.preventDefault();
            let currentObj = this;
            if (this.newBlog.id !== 0) {
                this.updateBlogItem();
                return false;
            }
            const config = {
                headers: { "content-type": "multipart/form-data" }
            };

            let formData = new FormData();
            formData.append("title", this.newBlog.title);
            formData.append("description", this.newBlog.description);
            formData.append("image", this.newBlog.image);

            axios
                .post("/api/blog", formData, config)
                .then(response => {
                    // currentObj.success = response.data.success;
                    console.log(response.data);
                    this.blogs.unshift(response.data);
                    this.newBlog = {
                        title: "",
                        description: "",
                        image: ""
                    };
                })
                .catch(error => {
                    console.log("Error");
                });
        },
        deleteItem(id) {
            axios.delete("api/blog/" + id).then(response => {
                console.log(response.data);
                this.blogs = this.blogs.filter(
                    blog => blog.id != response.data
                );
            });
        },
        editItem(blog) {
            console.log("Edit item");
            this.newBlog = {
                id: blog.id,
                title: blog.title,
                description: blog.description,
                image: blog.image
            };
        },
        updateBlogItem() {
            const config = {
                headers: { "content-type": "multipart/form-data" }
            };

            let formData = new FormData();
            formData.append("id", this.newBlog.id);
            formData.append("title", this.newBlog.title);
            formData.append("description", this.newBlog.description);
            formData.append("image", this.newBlog.image);

            console.log(this.newBlog);
            console.log(formData);

            axios
                .put("/api/blog/" + this.newBlog.id, this.newBlog)
                .then(response => {
                    // currentObj.success = response.data.success;
                    console.log("response.data");
                    console.log(response.data);
                    this.blogs = this.blogs.map(blog => {
                        if (blog.id == response.data.id) {
                            blog = response.data;
                            return blog;
                        }
                        return blog;
                    });
                    this.newBlog = {
                        id: 0,
                        title: "",
                        description: "",
                        image: ""
                    };
                })
                .catch(error => {
                    console.log("Error");
                });
        }
    },
    created() {
        this.getUser();
    }
};
</script>

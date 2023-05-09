import firebase from 'firebase'
// import localforage from 'localforage'

export default {
    methods: {
        uploadPhotoFirebase(url) {

            fetch(url)
                .then((res) => res.blob())
                .then((blob) => {
                    const file = new File([blob], "File name", { type: "image/png" });

                    let storageRef = firebase.storage().ref();
                    let uploadTask = storageRef.child(`profiles/${this.auth.id}_photo_profile`).put(file);

                    uploadTask.on(
                        firebase.storage.TaskEvent.STATE_CHANGED,
                        (snapshot) => {
                            let progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                            console.log("Upload is " + progress + "% done");
                        },
                        function(error) {
                            switch (error.code) {
                                case "storage/unauthorized":
                                    break;

                                case "storage/canceled":
                                    break;

                                case "storage/unknown":
                                    break;
                            }
                        },
                        () => {

                            uploadTask.snapshot.ref.getDownloadURL().then((downloadURL) => {
                                console.log('downloadURL photo', downloadURL)
                                this.auth.profile.photo = downloadURL
                                this.updateProfile()
                            })
                        }
                    );
                });

        },

        downloadPhotoFirebase(auth) {

            // localforage.getItem('helpDesk').then(item => {
            return firebase.storage().ref().child(`profiles/${auth.id}_photo_profile`).getDownloadURL()
                // })

        },
    }
}
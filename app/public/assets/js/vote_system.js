document.addEventListener('DOMContentLoaded', function () {
    console.log('votes js loaded');
    const voteBox = document.getElementById('vote-box');

    if (!voteBox) {
        return;
    }

    const voteUrl = voteBox.dataset.voteUrl;

    const likeCount = document.getElementById('like-count');
    const dislikeCount = document.getElementById('dislike-count');
    const likeButton = document.getElementById('like-button');
    const dislikeButton = document.getElementById('dislike-button');
    const voteMessage = document.getElementById('vote-message');

    function showMessage(message) {
        if (voteMessage) {
            voteMessage.textContent = message;
        }
    }

    function updateCounts(counts) {
        if (likeCount) {
            likeCount.textContent = counts.likes;
        }

        if (dislikeCount) {
            dislikeCount.textContent = counts.dislikes;
        }
    }

    function loadVotes() {
        fetch(voteUrl)
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                updateCounts(data);
            })
            .catch(function () {
                showMessage('Could not load votes.');
            });
    }

    function sendVote(voteType) {
        fetch(voteUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                vote_type: voteType
            })
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.counts) {
                    updateCounts(data.counts);
                }

                if (data.message) {
                    showMessage(data.message);
                }
            })
            .catch(function () {
                showMessage('Could not save vote.');
            });
    }

    loadVotes();

    if (likeButton) {
        likeButton.addEventListener('click', function () {
            sendVote('like');
        });
    }

    if (dislikeButton) {
        dislikeButton.addEventListener('click', function () {
            sendVote('dislike');
        });
    }
});
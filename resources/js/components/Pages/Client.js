import axios from 'axios'
import Alpine from 'alpinejs'

class Client {
    start() {
        document.addEventListener('alpine:init', () => {
            Alpine.data('client', (onlineCountEndpoint) => ({
                onlineCount: 0,
                showCmsFrame: false,
                onlineCountButtonDelay: false,
                isDisconnected: false,
                isPlaying: false,
                audioSource: window.streamUrl,

                endpoints: {
                    onlineCount: onlineCountEndpoint
                },

                init() {
                    document.addEventListener('nitro:disconnect', () => this.isDisconnected = true)

                    this.$nextTick(() => {
                        if (!this.endpoints.onlineCount) return

                        this.reloadOnlineCount()

                        setInterval(() => this.reloadOnlineCount(), this.getTime(30))

                        this.initRadioPlayer()

                        this.initFullscreenButton()
                    })
                },

                initRadioPlayer() {
                    this.audioPlayer = document.getElementById('audioPlayer');
                    const togglePlayButton = document.getElementById('togglePlayButton');
                    const playPauseIcon = document.getElementById('playPauseIcon');
                    const audioSource = this.audioSource;
                
                    if (!this.audioPlayer) return;
                
                    const createAudioConnection = () => {
                        this.audioPlayer.src = audioSource;
                
                        this.audioPlayer.play().then(() => {
                            this.isPlaying = true;
                            playPauseIcon.classList.remove('fa-play');
                            playPauseIcon.classList.add('fa-pause');
                        }).catch(error => {
                            console.error('Error al iniciar la reproducción:', error);
                        });
                    };
                
                    const destroyAudioConnection = () => {
                        this.audioPlayer.pause();
                        this.isPlaying = false;
                        playPauseIcon.classList.remove('fa-pause');
                        playPauseIcon.classList.add('fa-play');
                
                        this.audioPlayer.removeAttribute('src');
                        this.audioPlayer.load();
                    };
                
                    togglePlayButton.addEventListener('click', () => {
                        if (this.audioPlayer.paused) {
                            createAudioConnection();
                        } else {
                            destroyAudioConnection();
                        }
                    });

                    volumeDownButton.addEventListener('click', () => {
                        audioPlayer.volume = Math.max(0, audioPlayer.volume - 0.1);
                    });

                    volumeUpButton.addEventListener('click', () => {
                        audioPlayer.volume = Math.min(1, audioPlayer.volume + 0.1);
                    });
                },

                initFullscreenButton() {
                    const fullscreenButton = document.getElementById('fullscreenButton');

                    fullscreenButton.addEventListener('click', () => {
                        if (!document.fullscreenElement) {
                            document.documentElement.requestFullscreen().catch(err => {
                                alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
                            });
                        } else {
                            document.exitFullscreen();
                        }
                    });
                },

                toggleCms() {
                    this.showCmsFrame = !this.showCmsFrame
                },

                async reloadOnlineCount() {
                    if (this.onlineCountButtonDelay || !this.endpoints.onlineCount) return

                    this.onlineCountButtonDelay = true
                    this.onlineCount = '...'

                    await axios.get(this.endpoints.onlineCount)
                        .then(response => {
                            if (!response.data) {
                                this.onlineCount = 'N/A'
                                return
                            }

                            this.onlineCount = response.data.onlineCount
                        })
                        .catch(error => console.error('[OnlineCount] - ', error))

                    // 5 seconds delay to user reload online count manually
                    setTimeout(() => this.onlineCountButtonDelay = false, this.getTime(5))
                },

                getTime(seconds) {
                    return seconds * 1000
                }
            }))
        })
    }
}

export default new Client

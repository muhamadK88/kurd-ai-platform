<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>چوونەژوورەوە - کورد ئەی ئای</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Noto Sans Arabic', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-md border-t-4 border-blue-600">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-cyan-400 rounded-2xl flex items-center justify-center shadow-lg text-white font-black text-3xl mx-auto mb-4">ئـ</div>
            <h2 class="text-3xl font-black text-gray-800">بەخێربێیت</h2>
            <p class="text-gray-500 mt-2 font-bold text-sm">تکایە بۆ چوونەژوورەوە یان خۆتۆمارکردن فۆرمەکە پڕبکەرەوە</p>
        </div>

        <div id="error-message" class="hidden bg-red-50 text-red-600 text-sm font-bold p-3 rounded-xl mb-6 text-center border border-red-100 leading-relaxed"></div>
        <div id="success-message" class="hidden bg-green-50 text-green-700 text-sm font-bold p-4 rounded-xl mb-6 text-center border border-green-200 shadow-sm leading-relaxed"></div>

        <div class="space-y-4">
            <div>
                <input type="email" id="email" placeholder="ئیمێڵەکەت بنووسە" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-left transition" dir="ltr">
            </div>
            <div>
                <input type="password" id="password" placeholder="وشەی نهێنی (لانی کەم ٦ پیت/ژمارە)" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-left transition" dir="ltr">
                <div class="text-left mt-2">
                    <button id="forgot-password-btn" type="button" class="text-sm font-bold text-gray-500 hover:text-blue-600 transition">وشەی نهێنیت بیرچووە؟</button>
                </div>
            </div>
            
            <div class="pt-2 space-y-3">
                <button id="email-login-btn" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold text-lg hover:bg-blue-700 transition shadow-lg flex justify-center items-center gap-2">
                    چوونەژوورەوە
                </button>
                <button id="email-signup-btn" class="w-full bg-white text-blue-600 border-2 border-blue-600 py-3 rounded-xl font-bold hover:bg-blue-50 transition shadow-sm">
                    دروستکردنی هەژماری نوێ
                </button>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-between">
            <hr class="w-full border-gray-200">
            <span class="px-3 text-gray-400 text-sm font-bold whitespace-nowrap">یان بەکارهێنانی</span>
            <hr class="w-full border-gray-200">
        </div>

        <div class="mt-8">
            <button id="google-login-btn" class="w-full flex items-center justify-center gap-3 bg-white border border-gray-300 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-50 transition shadow-sm">
                <svg class="w-6 h-6" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 15.02 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                بەردەوامبوون لەگەڵ گووگڵ
            </button>
        </div>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, signInWithEmailAndPassword, createUserWithEmailAndPassword, GoogleAuthProvider, signInWithPopup, sendEmailVerification, signOut, sendPasswordResetEmail } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

        const firebaseConfig = {
            apiKey: "AIzaSyAizrzIAwVMDSXdu-Y0LYFDzwQPy79ThEs",
            authDomain: "ai-platform-adb1b.firebaseapp.com",
            databaseURL: "https://ai-platform-adb1b-default-rtdb.firebaseio.com",
            projectId: "ai-platform-adb1b",
            storageBucket: "ai-platform-adb1b.firebasestorage.app",
            messagingSenderId: "798560436587",
            appId: "1:798560436587:web:d4e3f4e5f862c7cbde0c2e"
        };

        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        
        auth.useDeviceLanguage();

        // لیستی ئەدمینەکان لێرەش زیاد دەکەین
        const adminEmails = ["team@kurd-ai.com", "mahamadkamaran890@gmail.com"];

        const errorMsg = document.getElementById('error-message');
        const successMsg = document.getElementById('success-message');

        function showError(text) {
            errorMsg.innerText = text;
            errorMsg.classList.remove('hidden');
            successMsg.classList.add('hidden');
        }

        function showSuccess(text) {
            successMsg.innerText = text;
            successMsg.classList.remove('hidden');
            errorMsg.classList.add('hidden');
        }

        // ١. لۆژیکی چوونەژوورەوە لەگەڵ ڕێگەپێدانی ئەدمینەکان
        document.getElementById('email-login-btn').addEventListener('click', () => {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if(email && password) {
                signInWithEmailAndPassword(auth, email, password)
                .then((userCredential) => {
                    const user = userCredential.user;
                    const isAdmin = adminEmails.includes(user.email);
                    
                    // ئەگەر ڤێریفای نەبوو وە هەروەها ئەدمینیش نەبوو (واتە خوێندکاری ئاسایی بوو)
                    if (!user.emailVerified && !isAdmin) {
                        signOut(auth).then(() => {
                            showError("تکایە سەرەتا سەردانی ئیمێڵەکەت بکە و هەژمارەکەت پشتڕاست بکەرەوە (Verify) پاشان لۆگین بکە.");
                        });
                    } else {
                        // ئەگەر ڤێریفای بوو، یان ئەگەر ئەدمین بوو، با بێتە ژوورەوە
                        window.location.href = "/";
                    }
                })
                .catch((error) => {
                    if (error.code === 'auth/invalid-credential') {
                        showError("ئیمێڵ یان وشەی نهێنی هەڵەیە، یان هەژمارەکە بوونی نییە.");
                    } else {
                        showError("کێشەیەک ڕوویدا: " + error.message);
                    }
                });
            } else {
                showError("تکایە ئیمێڵ و وشەی نهێنی پڕبکەرەوە.");
            }
        });

        document.getElementById('email-signup-btn').addEventListener('click', () => {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if(email && password) {
                createUserWithEmailAndPassword(auth, email, password)
                .then((userCredential) => {
                    const user = userCredential.user;
                    sendEmailVerification(user)
                    .then(() => {
                        signOut(auth).then(() => {
                            showSuccess("هەژمارەکەت سەرکەوتوویانە دروستکرا! ✨ نامەیەکی دڵنیاییمان نارد بۆ ئیمێڵەکەت. تکایە سەردانی ئیمێڵەکەت بکە و پشتڕاستی بکەرەوە پێش ئەوەی لۆگین بکەیت.");
                            document.getElementById('email').value = '';
                            document.getElementById('password').value = '';
                        });
                    });
                })
                .catch((error) => {
                    if(error.code === 'auth/email-already-in-use') {
                        showError("ئەم ئیمێڵە پێشتر بەکارهاتووە، تکایە لۆگین بکە یان ئیمێڵەکەت پشتڕاست بکەرەوە.");
                    } else if (error.code === 'auth/weak-password') {
                        showError("وشەی نهێنی لاوازە، دەبێت لانی کەم ٦ پیت یان ژمارە بێت.");
                    } else {
                        showError("کێشەیەک ڕوویدا: " + error.message);
                    }
                });
            } else {
                showError("تکایە سەرەتا ئیمێڵ و وشەی نهێنی پڕبکەرەوە.");
            }
        });

        const provider = new GoogleAuthProvider();
        document.getElementById('google-login-btn').addEventListener('click', () => {
            signInWithPopup(auth, provider)
            .then((result) => {
                window.location.href = "/";
            }).catch((error) => {
                if (error.code !== 'auth/popup-closed-by-user') {
                    showError("کێشەیەک ڕوویدا لە گووگڵ: " + error.message);
                }
            });
        });

        document.getElementById('forgot-password-btn').addEventListener('click', () => {
            const email = document.getElementById('email').value;
            
            if(!email) {
                showError("تکایە سەرەتا ئیمێڵەکەت لە بۆکسەکەدا بنووسە، پاشان کلیک لە 'وشەی نهێنیت بیرچووە؟' بکە بۆ ئەوەی لینکی گۆڕینت بۆ بنێرین.");
                return;
            }

            sendPasswordResetEmail(auth, email)
            .then(() => {
                showSuccess("لینکی گۆڕینی وشەی نهێنی نێردرا بۆ ئیمێڵەکەت! تکایە سەیری Inbox یان Spamـی ئیمێڵەکەت بکە.");
            })
            .catch((error) => {
                if(error.code === 'auth/invalid-email') {
                    showError("ئەم ئیمێڵە هەڵەیە یان بوونی نییە.");
                } else if(error.code === 'auth/user-not-found') {
                    showError("هیچ هەژمارێک بەم ئیمێڵەوە بوونی نییە لە سیستەمەکەماندا.");
                } else {
                    showError("کێشەیەک ڕوویدا: " + error.message);
                }
            });
        });
    </script>
</body>
</html>
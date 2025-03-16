const inputElem = document.getElementById('example'); // input要素
const currentValueElem = document.getElementById('current-value'); // 埋め込む先のspan要素

// 現在の値をspanに埋め込む関数
const setCurrentValue = (val) => {
  currentValueElem.innerText = val;
}

// inputイベント時に値をセットする関数
const rangeOnChange = (e) =>{
  setCurrentValue(e.target.value);
}

window.onload = () => {
  inputElem.addEventListener('input', rangeOnChange); // スライダー変化時にイベントを発火
  setCurrentValue(inputElem.value); // ページ読み込み時に値をセット
}

// ファンレター送信と決済機能を同時に行う
document.getElementById("submitBtn").addEventListener("click", async function () {
  const form = document.getElementById("letterForm");
  const formData = new FormData(form);

  try {
      // ファンレターを非同期で送信
      const response = await fetch("letter_insert.php", {
          method: "POST",
          body: formData
      });

      const result = await response.json();

      console.log(result); // レスポンス内容を確認

      if (result.success) {
          // レスポンスに含まれるリダイレクトURLに移動
          console.log("Redirecting to: " + result.redirect_url);
          window.location.href = result.redirect_url; // checkout.php へのリダイレクト
      } else {
          alert("送信に失敗しました: " + result.message);
      }
  } catch (error) {
      alert("エラーが発生しました: " + error);
  }
});

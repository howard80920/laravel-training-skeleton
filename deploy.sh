#!/bin/sh

# 執行方式:
# >> ./deploy.sh {--branch=develop} {--no-dev} {--with-cache}

set -e  # 讓腳本在遇到錯誤時自動停止

# 自動獲取當前腳本所在的目錄，並將其儲存為變數
SCRIPT_PATH="$(realpath "$0")"
SCRIPT_DIR="$(dirname "$SCRIPT_PATH")"
BRANCH="develop"        # 預設develop分支
REBUILD_CACHE=false     # 預設不重新產生快取
INSTALL_DEV=true        # 預設不安裝dev依賴

# 解析參數
for i in "$@"
do
  case $i in
    --branch=*)
      BRANCH="${i#*=}"
      shift
      ;;
    --no-dev)
      INSTALL_DEV=false  # 如果傳遞 --no-dev 參數，則不安裝dev依賴
      shift
      ;;
    --with-cache)
      REBUILD_CACHE=true  # 如果傳遞 --with-cache 參數，則重新產生快取
      shift
      ;;
    *)
      # 處理其他參數（如果有的話）
      ;;
  esac
done

# 定義共用函式
run_cmd() {
  CMD="$1"
  echo ">>> - 執行指令: $CMD"
  $CMD > /dev/null 2>&1 || {
    echo ">>> - 執行指令失敗：$CMD" >&2;
    echo "## 中斷執行 ##";
    exit 1;
  }
}

# 自動獲取當前腳本所在的目錄，並進入該目錄
cd $SCRIPT_DIR || exit

echo '## 開始部署 ##';
echo ">>> 操作目錄: $SCRIPT_DIR"

# Git處理
echo ">>> 重置 Git 變更..."
git reset --hard
echo ">>> 拉取分支 $BRANCH 的最新程式碼..."
git pull origin $BRANCH
echo ">>> 切換至分支 $BRANCH..."
git checkout $BRANCH
git pull

# 更新 Composer 依賴並優化 autoloader
if [ "$INSTALL_DEV" = true ]; then
  echo ">>> 更新 Composer 依賴(包括dev)..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
else
  echo ">>> 更新 Composer 依賴..."
  composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
fi

# 清除 Laravel 快取
echo ">>> 清除Laravel快取..."
CLEAR_CMDS=(
  "php artisan config:clear"
  "php artisan route:clear"
  "php artisan view:clear"
  "php artisan event:clear"
)
for CMD in "${CLEAR_CMDS[@]}"; do
  run_cmd "$CMD"
done

# 重新產生快取 (選擇性)
if [ "$REBUILD_CACHE" = true ]; then
  echo ">>> 建立Laravel快取..."
  CACHE_CMDS=(
    "php artisan config:cache"
    "php artisan route:cache"
    "php artisan view:cache"
    "php artisan event:cache"
  )
  for CMD in "${CACHE_CMDS[@]}"; do
    run_cmd "$CMD"
  done
fi

# 重啟Laravel horizon
echo ">>> 重啟Laravel Horizon..."
run_cmd "php artisan horizon:terminate"

echo "## 部署完成 ($BRANCH) ##"

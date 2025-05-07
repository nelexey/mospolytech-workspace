const resolveBtn = document.getElementsByClassName('resolve-button')[0]

// Первое задание на промис

resolveBtn.addEventListener('click', () => {
    console.log('Doing job...')
    const jobPromsie = new Promise((resolve, reject) => {
        setTimeout(() => {
            resolve('Job done!!')
        }, 2000)
    })

    console.log(jobPromsie.then(result => {console.log(result)}))
})

// Второе задание

const getData = (errorProbability = 0.5, dataString) => {
    const syntheticData = "Синтетические данные: " + dataString;

    return (input) => {
        if (typeof input !== 'number' || isNaN(input)) {
            throw new Error("Аргумент должен быть числом");
        }

        const randomValue = Math.random();
        if (randomValue < errorProbability) {
            return null;
        } else {
            return syntheticData;
        }
    };
};

const getDataBtn = document.getElementById('get-data-button');
const input = document.getElementById('input-num');

getDataBtn.addEventListener('click', () => {
    const getDataPromise = new Promise((resolve, reject) => {
        setTimeout(() => {
            const inputValue = input.value;
            const fetchData = getData(0.5, "Пример данных");

            try {
                const result = fetchData(Number(inputValue));
                if (result === null) {
                    reject("Ошибка: данные не получены");
                } else {
                    resolve(result);
                }
            } catch (error) {
                reject(error.message);
            }
        }, 2000);
    });

    getDataPromise
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error(error);
        });
});


// задание на крафт

const inventory = {
    wood: 5,
    ironOre: 5,
    stick: 0,
    ironIngot: 0,
    pickaxe: 0
};

const items = {
    wood: {
        name: 'Дерево',
        craftingTime: 1000,
        requiredItems: [],
        failProbability: 0.1
    },
    ironOre: {
        name: 'Железная руда',
        craftingTime: 1500,
        requiredItems: [],
        failProbability: 0.2
    },
    stick: {
        name: 'Палка',
        craftingTime: 2000,
        requiredItems: ['wood'],
        failProbability: 0.15
    },
    ironIngot: {
        name: 'Железный слиток',
        craftingTime: 3000,
        requiredItems: ['ironOre'],
        failProbability: 0.25
    },
    pickaxe: {
        name: 'Кирка',
        craftingTime: 4000,
        requiredItems: ['stick', 'ironIngot'],
        failProbability: 0.3
    }
};

function updateInventoryDisplay() {
    const inventoryList = document.getElementById('inventory-list');
    inventoryList.innerHTML = '';
    
    for (const [itemId, count] of Object.entries(inventory)) {
        const li = document.createElement('li');
        li.textContent = `${items[itemId].name}: ${count}`;
        inventoryList.appendChild(li);
    }
}

function craftItem(itemId) {
    const item = items[itemId];
    const progressList = document.getElementById('craft-progress-list');
    
    const craftTask = document.createElement('div');
    craftTask.className = 'craft-task';
    
    const craftHeader = document.createElement('h4');
    craftHeader.textContent = `Крафт: ${item.name}`;
    craftTask.appendChild(craftHeader);
    
    const craftStatus = document.createElement('div');
    craftStatus.className = 'main-status';
    craftTask.appendChild(craftStatus);
    
    const craftDetails = document.createElement('div');
    craftDetails.className = 'craft-details';
    craftTask.appendChild(craftDetails);
    
    progressList.appendChild(craftTask);
    
    const button = document.getElementById(`craft-${itemId}`);
    button.disabled = true;
    
    if (item.requiredItems.length > 0) {
        const recipe = document.createElement('div');
        recipe.className = 'recipe';
        recipe.textContent = `Рецепт: ${item.requiredItems.map(id => items[id].name).join(' + ')}`;
        craftDetails.appendChild(recipe);
    }
    
    const missingItems = checkRequiredItems(itemId);
    
    if (missingItems.length > 0) {
        craftStatus.textContent = `Не хватает предметов для ${item.name}. Пытаемся создать...`;
        
        const missingItemsList = document.createElement('div');
        missingItemsList.className = 'missing-items';
        craftDetails.appendChild(missingItemsList);
        
        const craftPromises = [];
        
        for (const missingItemId of missingItems) {
            const missingItem = items[missingItemId];
            
            const missingItemDiv = document.createElement('div');
            missingItemDiv.className = 'sub-craft';
            missingItemDiv.innerHTML = `<span>➡️ Создаем ${missingItem.name}... (${missingItem.craftingTime}ms)</span>`;
            missingItemsList.appendChild(missingItemDiv);
            
            const subProgressBar = document.createElement('div');
            subProgressBar.className = 'progress-bar';
            missingItemDiv.appendChild(subProgressBar);
            
            let progress = 0;
            const interval = setInterval(() => {
                progress += 1;
                subProgressBar.style.width = `${progress}%`;
                if (progress >= 100) clearInterval(interval);
            }, missingItem.craftingTime / 100);
            
            craftPromises.push(
                new Promise((resolve, reject) => {
                    setTimeout(() => {
                        const success = Math.random() > missingItem.failProbability;
                        
                        if (success) {
                            inventory[missingItemId]++;
                            missingItemDiv.innerHTML += `<span class="success">✅ Создан ${missingItem.name}!</span>`;
                            resolve(true);
                        } else {
                            missingItemDiv.innerHTML += `<span class="failure">❌ Не удалось создать ${missingItem.name}!</span>`;
                            reject(`Не удалось создать ${missingItem.name}`);
                        }
                        
                        updateInventoryDisplay();
                    }, missingItem.craftingTime);
                })
            );
        }
        
        Promise.all(craftPromises)
            .then(() => {
                const stillMissing = checkRequiredItems(itemId);
                
                if (stillMissing.length === 0) {
                    craftStatus.textContent = `Все компоненты готовы! Создаем ${item.name}...`;
                    return craftMainItem(itemId, craftStatus, craftDetails);
                } else {
                    throw new Error(`Не удалось создать все требуемые предметы для ${item.name}`);
                }
            })
            .catch((error) => {
                craftStatus.textContent = `Ошибка: ${error}`;
                craftStatus.className = 'main-status failure';
                button.disabled = false;
            });
    } else {
        craftStatus.textContent = `Все компоненты готовы! Создаем ${item.name}...`;
        
        craftMainItem(itemId, craftStatus, craftDetails)
            .then(() => {
                button.disabled = false;
            })
            .catch(() => {
                button.disabled = false;
            });
    }
}

function checkRequiredItems(itemId) {
    const item = items[itemId];
    const missingItems = [];
    
    for (const requiredItemId of item.requiredItems) {
        if (inventory[requiredItemId] <= 0) {
            missingItems.push(requiredItemId);
        }
    }
    
    return missingItems;
}

function craftMainItem(itemId, statusEl, detailsEl) {
    const item = items[itemId];
    
    const mainCraftDiv = document.createElement('div');
    mainCraftDiv.className = 'main-craft';
    mainCraftDiv.innerHTML = `<span>🔨 Изготавливаем ${item.name}... (${item.craftingTime}ms)</span>`;
    detailsEl.appendChild(mainCraftDiv);
    
    const mainProgressBar = document.createElement('div');
    mainProgressBar.className = 'progress-bar';
    mainCraftDiv.appendChild(mainProgressBar);
    
    let progress = 0;
    const interval = setInterval(() => {
        progress += 1;
        mainProgressBar.style.width = `${progress}%`;
        if (progress >= 100) clearInterval(interval);
    }, item.craftingTime / 100);
    
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            for (const requiredItemId of item.requiredItems) {
                inventory[requiredItemId]--;
            }
            
            const success = Math.random() > item.failProbability;
            
            if (success) {
                inventory[itemId]++;
                statusEl.textContent = `Успешно создан ${item.name}!`;
                statusEl.className = 'main-status success';
                mainCraftDiv.innerHTML += `<span class="success">✅ ${item.name} создан!</span>`;
                resolve(true);
            } else {
                statusEl.textContent = `Не удалось создать ${item.name}!`;
                statusEl.className = 'main-status failure';
                mainCraftDiv.innerHTML += `<span class="failure">❌ ${item.name} не создан!</span>`;
                reject(false);
            }
            
            updateInventoryDisplay();
        }, item.craftingTime);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.craft-button').forEach(button => {
        const itemId = button.getAttribute('data-item');
        button.addEventListener('click', () => craftItem(itemId));
    });
    
    updateInventoryDisplay();
});
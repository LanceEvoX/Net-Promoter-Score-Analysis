from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from sklearn.linear_model import LogisticRegression
import numpy as np

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # Adjust this to restrict the origins
    allow_credentials=True,
    allow_methods=["*"],  # Allows all methods (GET, POST, etc.)
    allow_headers=["*"],  # Allows all headers
)


sentiments = np.array([
    # 0–100 range
    [80, 10, 10], [60, 20, 20], [30, 40, 30], [20, 10, 70], [5, 10, 30],
    [90, 5, 5], [10, 10, 80], [20, 10, 15], [5, 45, 35], [20, 5, 5],

    # 0–1000 range
    [800, 100, 100], [600, 200, 200], [300, 400, 300], [200, 100, 700],
    [50, 100, 300], [900, 50, 50], [10, 10, 100], [100, 100, 150],
    [10, 100, 10], [100, 10, 10],

    # 0–100 range
    [85, 10, 5], [75, 15, 10], [35, 30, 20], [25, 30, 45], [10, 20, 70],
    [5, 5, 90], [80, 60, 20], [60, 40, 10], [15, 20, 65], [20, 40, 40],

    # 0–1000 range
    [850, 100, 50], [750, 150, 100], [350, 300, 200], [250, 300, 450],
    [100, 200, 700], [50, 50, 900], [850, 650, 250], [650, 250, 150],
    [150, 250, 600], [300, 500, 200],
])

endorsed = np.array([
    1, 1, 0, 0, 0, 1, 0, 0, 0, 1,
    1, 1, 0, 0, 0, 1, 0, 0, 0, 1,
    1, 1, 0, 0, 0, 0, 1, 1, 0, 0,
    1, 1, 0, 0, 0, 0, 1, 1, 0, 0
])


# Train Logistic Regression Model
log_reg_model = LogisticRegression()
log_reg_model.fit(sentiments, endorsed)

class SentimentRequest(BaseModel):
    positive: int
    neutral: int
    negative: int

@app.post("/predict-nps")
def predict_nps(request: SentimentRequest):
    data = np.array([[request.positive, request.neutral, request.negative]])
    prediction = log_reg_model.predict(data)
    return {"nps_result": "Endorsed" if prediction[0] == 1 else "Not Endorsed"}

print("Prediction Started....")
import numpy as np
import pandas as pd
import quandl
import os

quandl.ApiConfig.api_key = 'EpVb5SE59swkaGuHM_yN'
f = open("predict_input.txt", "r")
comp=f.readline().rstrip()
while comp:
	trainingSet = quandl.get(comp, start_date="2014-12-31", end_date="2018-12-31")
	trainingSet = trainingSet.iloc[:,1:2].values
	from sklearn.preprocessing import MinMaxScaler
	sc = MinMaxScaler()
	trainingSet = sc.fit_transform(trainingSet)
	xTrain = trainingSet[0:len(trainingSet)-1]
	yTrain = trainingSet[1:len(trainingSet)+2]
	xTrain = np.reshape(xTrain, (len(trainingSet)-1, 1, 1 ))
	from keras.models import Sequential
	from keras.layers import Dense
	from keras.layers import LSTM
	model = Sequential()
	model.add(LSTM(units = 4, activation = 'sigmoid', input_shape=(None, 1)))
	model.add(Dense(units=1))
	model.compile(optimizer='adam', loss = 'mean_squared_error')
	model.fit(x =xTrain , y =yTrain , batch_size=600, epochs=10, verbose=0)
	model.save_weights('TrainedRNN.h5')
	testSet = quandl.get(comp)
	realStockPrice = testSet.iloc[:, 1:2].values
	inputs = realStockPrice
	inputs = sc.transform(inputs)
	inputs = np.reshape(inputs, (len(inputs),1,1))
	prediction = model.predict(inputs)
	prediction = sc.inverse_transform(prediction)
	import matplotlib.pyplot as plt
	import matplotlib.ticker as ticker
	plt.plot(realStockPrice, color = 'green', label='RealPrice')
	plt.plot(prediction, color = 'blue', label='Predicted')
	plt.xlabel('days')
	plt.ylabel('Price')
	plt.title('Predictied Output')
	plt.legend()
	plt.savefig(comp+".jpg")
	plt.close()
	comp=f.readline().rstrip()	
f.close()

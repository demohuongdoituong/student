using UnityEngine;
using System.Collections;

public class playerDestroy : MonoBehaviour {
	public int pointAdd = 100;
	// Use this for initialization
	void Start () {

	}

	void OnCollisionEnter2D(Collision2D target){
		if (target.gameObject.name == "Player") {
			point.Addpoint (pointAdd);
			Destroy(gameObject);
		}
	}

	// Update is called once per frame
	void Update () {

	}
}
